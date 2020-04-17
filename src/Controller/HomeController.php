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
    public function __construct(ArticlesRepository $repository){
        $this->repository=$repository;
    }
    

    /**
     * @Route("/home", name="home_index")
     * @Route("/", name="homehome_index2")
     * @param mixed 
     * @return Response
     */
    public function index( ): Response
    {
         $articles = $this->repository->findAll();
         
         return $this->render('home/index.html.twig', [
            'current_menu' => 'home', 
            'controller_name' => 'HomeController',
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/apropos", name="index_apropos")
     */
    public function apropos()
    {   
        
        $articles = $this->repository->findCategorie();

        return $this->render('home/about.html.twig', [
            'controller_name' => 'HomeController',
            'current_menu' => 'apropos', 
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('contact.html.twig', [
            'controller_name' => 'HomeController',
            'current_menu' => 'contact', 
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
