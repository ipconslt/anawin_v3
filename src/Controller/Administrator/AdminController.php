<?php

namespace App\Controller\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/administrator")
*/
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function index()
    {
        return $this->render('administrator/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}