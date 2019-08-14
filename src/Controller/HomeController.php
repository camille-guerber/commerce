<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *     path="/",
 * )
 */
class HomeController extends AbstractController
{
    /**
     * @Route(
     *     path="/",
     *     name="home_index"
     * )
     */
    public function index()
    {
        return $this->redirectToRoute('search_product');
    }
}