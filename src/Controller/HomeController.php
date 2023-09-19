<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/home")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home_index")
     */
    public function index()
    {
        // visual of the page in the back for the diets
        return $this->render('home/index.html.twig');
    }
}