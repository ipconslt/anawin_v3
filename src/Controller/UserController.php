<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="user")
     */

    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',

        ]);
    }


    /**
     * @Route("/users", name="users")
     */
    public function utilisateur()
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();
        
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users'=> $users
        ]);
    }
}
