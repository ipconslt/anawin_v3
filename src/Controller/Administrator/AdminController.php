<?php

namespace App\Controller\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/administrator", name="administrator_")
 */

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     *  @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('administrator/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}