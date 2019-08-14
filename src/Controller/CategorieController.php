<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *     path="/leboncoin"
 * )
 */
class CategorieController extends AbstractController
{
    /**
     * @Route(
     *     path="/create/category",
     *     name="create_category"
     * )
     */
    public function create(Request $request)o
    {
        $categoryForm = $this->createForm(CategorieType::class);

        $categoryForm->handleRequest($request);

        if($categoryForm->isSubmitted() && $categoryForm->isValid()){
            $data = $categoryForm->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            $this->addFlash('notice', 'La catégorie '.$data->getNom().' a été ajoutée.');
            return $this->redirectToRoute('home_index');
        }

        return $this->render('category/create.html.twig', [
            'form' => $categoryForm->createView(),
            'title' => 'Créer une catégorie',
        ]);
    }

    /**
     * @Route(
     *     path="/edit/category/[id}",
     *     name="edit_category",
     *     requirements={"id"="\d+"}
     * )
     */
    public function edit(Request $request, $id)
    {
        $category = $this->getDoctrine()->getRepository(Categorie::class)->find($id);

        $categoryEditForm = $this->createForm(CategorieType::class, $category);
        $categoryEditForm->getForm();
        $categoryEditForm->handleRequest($request);

        if($categoryEditForm->isSubmitted() && $categoryEditForm->isValid()) {
            $categoryData = $categoryEditForm->getData();

            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->render('category/edit.html.twig', [
            'form' => $categoryEditForm,
            'title' => "Editer la catégorie : ".$category->getNom(),
        ]);
    }

    /**
     * @Route(
     *     path="/view/category/{id}",
     *     name="view_category",
     *     requirements={"id"="\d+"}
     * )
     */
    public function view($id)
    {
        $category = $this->getDoctrine()->getRepository(Categorie::class)->find($id);

        return $this->render('category/view.html.twig', [
            'category' => $category,
            'title' => 'Appercu de la catégorie : '.$category->getNom(),
        ]);
    }
}