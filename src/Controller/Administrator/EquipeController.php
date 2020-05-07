<?php

namespace App\Controller\Administrator;

use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/administrator")
 */
class EquipeController extends AbstractController
{
    /**
     * @Route("/equipe", name="equipe_administrator_index")
     */
    public function index(EquipeRepository $equipeRepository): Response
    {
        return $this->render('administrator/equipe/index.html.twig', [
            'controller_name' => 'Administrator/EquipeController',
            'equipes' => $equipeRepository->findAll(),
        ]);
    }

    
    /**
     * @Route("/equipe/new", name="equipe_administrator_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $equipe = new Equipe();
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();

            return $this->redirectToRoute('equipe_administrator_index');
        }

        return $this->render('administrator/equipe/new.html.twig', [
            'equipe' => $equipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/equipe/{id}", name="equipe_administrator_show", methods={"GET"})
     */
    public function show(Equipe $equipe): Response
    {
        return $this->render('administrator/equipe/show.html.twig', [
            'equipe' => $equipe,
        ]);
    }

    /**
     * @Route("/equipe/{id}/edit", name="equipe_administrator_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Equipe $equipe): Response
    {
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipe_index');
        }

        return $this->render('administrator/equipe/edit.html.twig', [
            'equipe' => $equipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/equipe/{id}", name="equipe_administrator_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Equipe $equipe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($equipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('equipe_index');
    }
}
