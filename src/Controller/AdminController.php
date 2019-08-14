<?php

namespace App\Controller;


use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *     path="/leboncoin/admin"
 * )
 */
class AdminController extends AbstractController
{
    /**
     * @Route(
     *     path="/index",
     *     name="admin_index"
     * )
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'title' => "Administration",
        ]);
    }

    /**
     * @Route(
     *     path="/products",
     *     name="admin_products"
     * )
     */
    public function productsList(Request $request)
    {
        $products = $this->getDoctrine()->getRepository(Produit::class)->findAll();

        $defaultData = ['message' => 'Filtres'];

        $sortForm = $this->createFormBuilder($defaultData)
            ->add('sort', ChoiceType::class, [
                'choices' => [
                    'Prix' => [
                        'Prix croissant' => 'ASC_prix',
                        'Prix décroissant' => 'DESC_prix',
                    ],
                    'Date de publication' => [
                        'Les plus récentes' => 'DESC_pub',
                        'Les plus anciennes' => 'ASC_pub',
                    ]
                ],
                'label' => 'Trier par',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Appliquer les filtres',
            ])
            ->getForm();

        $sortForm->handleRequest($request);

        if($sortForm->isSubmitted() && $sortForm->isValid()) {
            $data = $sortForm->getData();
            switch ($data['sort']) {
                case 'ASC_prix':
                    $products = $this->getDoctrine()->getRepository(Produit::class)->findAllOrderByPrix('ASC');
                break;
                case 'DESC_prix':
                    $products = $this->getDoctrine()->getRepository(Produit::class)->findAllOrderByPrix('DESC');
                break;
                case 'ASC_pub':
                    $products = $this->getDoctrine()->getRepository(Produit::class)->findAllOrderByDateCreation('ASC');
                break;
                case 'DESC_pub':
                    $products = $this->getDoctrine()->getRepository(Produit::class)->findAllOrderByDateCreation('DESC');
                break;
            }
        }

        return $this->render('admin/products.html.twig', [
            'title' => "Liste des annonces",
            'products' => $products,
            'form' => $sortForm->createView(),
        ]);
    }

    /**
     * @Route(
     *     path="/categories",
     *     name="admin_categories"
     * )
     */
    public function categoriesList(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();

        return $this->render('admin/categories.html.twig', [
            'categories' => $categories,
            'title' => 'Liste des catégories',
        ]);
    }
}