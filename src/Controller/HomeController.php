<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Articles;

use App\Repository\ArticlesRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



 class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home_index")
     * @Route("/", name="homehome_index2")
     */
    public function index(ArticlesRepository $articles): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'articles' => $articles->findAll(),
        ]);
    }

    /**
     * @Route("/apropos", name="apropos")
     */
    public function apropos()
    {
        return $this->render('sidebar-right.html', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/page", name="page")
     */
    public function page()
    {
        return $this->render('page_right.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

}
