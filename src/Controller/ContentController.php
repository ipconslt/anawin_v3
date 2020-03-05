<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContentController extends AbstractController
{
    /**
     * @Route("/content", name="content")
     */
    public function index()
    {
        return $this->render('content/index.html.twig', [
            'controller_name' => 'ContentController',
        ]);
    }

    /**
     * @Route("/categorie", name="admin_categorie")
     */
    public function categorie()
    {
        return $this->render('content/categorie.html.twig', [
            'controller_name' => 'ContentController',
        ]);
    }

    
}
