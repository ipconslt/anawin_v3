<?php

namespace App\Controller\Administrator;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Entity\Categorie;
use App\Form\CategorieType;

use App\Repository\ArticlesRepository;

#use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


    /**
     * @Route("/administrator/articles")
     */
    class ArticlesController extends AbstractController
{
   
    
    /**
     * @param ArticlesRepository $repository
     * @param ObjectManager $em
     * @return void
     */
    public function __construct(ArticlesRepository $repository, EntityManagerInterface $em){
        $this->repository=$repository;
        $this-> em = $em;
    }


    /**
     * @Route("/", name="articles_administrator_index",  methods={"GET"})
     */
    public function index(ArticlesRepository $articlesRepository, PaginatorInterface $paginator, Request $request):Response
    {
        #$articles = $this->repository->findCategorie();
        #$articles = $this->repository->findAll();
        $articles = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
           5 /*limit per page*/
        );
        
        return $this->render('administrator/articles/index.html.twig', [
            'current_menu' => 'articles',
            'articles' => $articles,
        ]);
    }

     /**
     * @Route("/article/new", name="articles_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        #    $entityManager = $this->getDoctrine()->getManager();
            $this->em->persist($article);
            $this->em->flush();
            $this->addFlash('success', 'Cet article est enregistré avec Success !');

            return $this->redirectToRoute('articles_administrator_index');
        }

        return $this->render('administrator/articles/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="articles_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Articles $article): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            #$this->getDoctrine()->getManager()->flush();
            $this->em->flush();
            $this->addFlash('success', 'Cet article est edité avec Success !');

            return $this->redirectToRoute('articles_administrator_index');
        }

        return $this->render('/administrator/articles/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="articles_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Articles $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
            $this->addFlash('success', 'Cet article est Supprimé avec Success !');
        }

        return $this->redirectToRoute('articles_administrator_index');
    }

}
