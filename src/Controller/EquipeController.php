<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Entity\Contact;
use App\Form\ContactType;

use App\Alertes\ContactAlerte;

use Cocur\Slugify\Slugify;
use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equipe")
 */
class EquipeController extends AbstractController
{
    /**
     * @Route("/", name="equipe_index", methods={"GET"})
     */
    public function index(EquipeRepository $equipeRepository): Response
    {
        return $this->render('equipe/index.html.twig', [
            'equipes' => $equipeRepository->findAll(),
        ]);
    }
    
    
    /**
     * @Route("/{slug}-{id}", name="equipe_show", requirements={"slug":"[a-z0-9\-]*"})
    * @param  equipe $equipe
    * @return Response
    */
    public function show(Equipe $equipe, string $slug, Request $request, ContactAlerte $alert): Response
    {
        if($equipe->getSlug() !==$slug){
            return $this->redirectToRoute('equipe_show',
            ['id'=>$property->getId(),
            'slug'=>$property->getslug()],
            301);
        }
        
        $contact = new Contact();
        $contact->setEquipe($equipe);
        $form= $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isvalid()) {
            $alert->alerte($contact);
            $this->addFlash('success', 'votre Email a été envoyé avec succès!');
           
          /* return $this->redirectToRoute('equipe_show', [
                'id' => $equipe->getId(),
                'slug' => $equipe->getSlug() 
                ]);*/
        }
                 
        return $this->render('equipe/show.html.twig', [
            'equipe' => $equipe,
            'form' => $form->createView()
        ]);
    
    }
    
}