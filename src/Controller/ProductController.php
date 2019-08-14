<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Image;
use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Produit;
use App\Form\ImageType;
use App\Form\MarqueType;
use App\Form\ModeleType;
use App\Form\ProduitType;
use App\Form\SearchType;
use App\Form\VoitureType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Choice;

/**
 * @Route(
 *     path="/leboncoin"
 * )
 */
class ProductController extends AbstractController
{
    /**
     * @Route(
     *     path="/create/product",
     *     name="create_product"
     * )
     */
    public function create(Request $request)
    {

        $user = $this->getUser();

        if(null === $user) {
            $this->addFlash('notice', 'Vous devez être connecté pour déposer une annonce.');
            return $this->redirectToRoute('app_login');
        }

        $title = null;

        $productForm = $this->createForm(ProduitType::class);

        $productForm->handleRequest($request);

        if($productForm->isSubmitted() && $productForm->isValid()){

            $product = $productForm->getData();

            $marque = $productForm->get('carmarque')->getData();
            $modeleid = $productForm->get('carmodeleid')->getData();
            $modele = $this->getDoctrine()->getRepository(Modele::class)->find($modeleid);


            $product->getImageOne()->upload($this->getParameter('img_directory'));
            $product->getImageTwo()->upload($this->getParameter('img_directory'));
            $product->getImageThree()->upload($this->getParameter('img_directory'));

            $product->setUser($user);

            $product->setMarque($marque);

            $product->setModele($modele);

            $product->setIsActive(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('notice', "Votre annonce a bien été déposée.");

            return $this->redirectToRoute('search_product');
        }

        return $this->render('product/create.html.twig', [
            'form' => $productForm->createView(),
            'title' => 'Déposer une annonce'.$title,
        ]);
    }

    public function sidebar($max)
    {
        $lastProducts = $this->getDoctrine()->getRepository(Produit::class)->findLastProducts($max);

        if(null === $lastProducts) {
            $lastProducts = $this->getDoctrine()->getRepository(Produit::class)->findBy([
                'limit' => 5,
            ]);
        }
        return $this->render('product/sidebar.html.twig', [
            'products' => $lastProducts,
            'title' => 'Dernières annonces',
        ]);
    }

    /**
     * @Route(
     *     path="/get/modeles",
     *     name="get_modeles",
     * )
     */
    public function getModeles(Request $request)
    {
        $id = $request->request->get('marque');
        $marque = $this->getDoctrine()->getRepository(Marque::class)->findOneBy([
            'id' => $id,
        ]);
        $modeles = $marque->getModeles();

        $modelesArray = [];

        foreach ($modeles as $modele) {
            $modelesArray[$modele->getId()] = $modele->getNom();
        }

        return new JsonResponse([
            'modeles' => $modelesArray,
        ]);
    }

    /**
     * @Route(
     *     path="/edit/product/{id}",
     *     name="edit_product",
     *     requirements={"id"="\d+"}
     * )
     */
    public function edit(Request $request, $id)
    {
        $product = $this->getDoctrine()->getRepository(Produit::class)->find($id);

        if(null === $product) {
            $this->addFlash('notice', "L'annonce portant l'ID ".$id." n'existe pas");
            return $this->redirectToRoute('home_index');
        }

        $editForm = $this->createForm(ProduitType::class, $product);
        $editForm->add('voiture', VoitureType::class);
        $editForm->remove('submit');
        $editForm->add('edit', SubmitType::class, [
            'label' => "Editer l'annonce",
        ]);

        $editForm->handleRequest($request);

        if($editForm->isSubmitted() && $editForm->isValid()) {
            $productToEdit = $editForm->getData();

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            $this->addFlash('notice', "L'annonce - ".$productToEdit->getNom()." - a bien été éditée.");

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('product/edit.html.twig', [
            'title' => "Editer cette annonce",
            'form' => $editForm->createView(),
            'product' => $product,
        ]);
    }


    /**
     * @Route(
     *     path="/view/product/{id}",
     *     name="view_product",
     *     requirements={"id"="\d+"}
     * )
     */
    public function view($id)
    {
        $product = $this->getDoctrine()->getRepository(Produit::class)->find($id);

        return $this->render('product/view.html.twig', [
            'product' => $product,
            'title' => $product->getNom(),
        ]);
    }

    /**
     * @Route(
     *     path="/search/product",
     *     name="search_product"
     * )
     */
    public function search(Request $request, PaginatorInterface $paginator)
    {
        $searchForm = $this->createForm(SearchType::class);

        $searchForm->handleRequest($request);

        $data = $request->query->all();

        $filters = [];

        $modeles = [];

        $marqueObj = null;
        $modeleObj = null;
        $tri = null;

        if(!empty($data['search'])) {

            $filters = $data['search'];

            switch ($filters['sort']) {
                case 'ASC_prix':
                    $tri = 'Prix croissant';
                    break;
                case 'DESC_prix':
                    $tri = 'Prix décroissant';
                    break;
                case 'ASC_pub':
                    $tri = 'Les + anciennes';
                    break;
                case 'DESC_pub':
                    $tri = 'Les + récentes';
                    break;
            }

            $marqueid = $filters['carmarque'];
            $modeleid = $filters['carmodeleid'];

            if(!empty($marqueid)) {
                $marqueObj = $this->getDoctrine()->getRepository(Marque::class)->find($marqueid);
                $modeles = $marqueObj->getModeles();
            }

            if(!empty($modeleid)) {
                $modeleObj = $this->getDoctrine()->getRepository(Modele::class)->find($modeleid);
            }

            $products = $this->getDoctrine()->getRepository(Produit::class)->search($filters, $marqueid, $modeleid);
        } else {
            $products = $this->getDoctrine()->getRepository(Produit::class)->findAllOrderByDateCreation('DESC');
        }

        $pagination = $paginator->paginate($products, $request->query->getInt('page', 1), 6);

        $count = count($products);

        return $this->render('product/search.html.twig', [
            'filters' => $filters,
            'products' => $pagination,
            'modeles' => $modeles,
            'marque' => $marqueObj,
            'modele' => $modeleObj,
            'tri' => $tri,
            'total' => $count,
            'form' => $searchForm->createView(),
            'title' => 'Que cherchez-vous ?',
        ]);
    }

    /**
     * @param Request $request
     * @param $annonceId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route(
     *     path="/activate/product/{id}",
     *     name="activate_product",
     *     requirements={"id"="\d+"}
     * )
     */
    public function activerAnnonce(Request $request, $id)
    {
        $annonce = $this->getDoctrine()->getRepository(Produit::class)->find($id);

        $annonce->setIsActive(true);

        $em = $this->getDoctrine()->getManager();

        $em->flush();

        $this->addFlash('notice', "L'annonce ".$annonce->getNom()." a bien été activée.");

        return $this->redirectToRoute('app_annonces');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route(
     *     path="/disable/product/{id}",
     *     name="disable_product",
     *     requirements={"id"="\d+"}
     * )
     */
    public function desactiverAnnonce(Request $request, $id)
    {
        $annonce = $this->getDoctrine()->getRepository(Produit::class)->find($id);

        $annonce->setIsActive(false);

        $em = $this->getDoctrine()->getManager();

        $em->flush();

        $this->addFlash('notice', "L'annonce ".$annonce->getNom()." a bien été désactivée.");

        return $this->redirectToRoute('app_annonces');
    }
    /**
     * @Route(
     *     path="/delete/product/{id}",
     *     name="delete_product",
     *     requirements={"id"="\d+"}
     * )
     */
    public function delete($id)
    {
        $product = $this->getDoctrine()->getRepository(Produit::class)->find($id);

        $em = $this->getDoctrine()->getManager();

        $em->remove($product);

        $em->flush();

        $this->addFlash('notice', "L'annonce ".$product->getNom()." a bien été supprimée");
        return $this->redirectToRoute('admin_products');
    }

}