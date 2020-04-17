<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Entity\Comment;
use App\Form\CommentType;

use App\Repository\ArticlesRepository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;

USE FOS\CKEditorBundle\Form\Type\CKEditorType;


/**
 * @Route("/articles")
 */
class ArticlesController extends AbstractController
{
    public function __construct(ArticlesRepository $repository){
        $this->repository=$repository;
    }

    /**
     * @Route("/", name="articles_index", methods={"GET"})
     */
    public function index( ): Response
    {
        #$articles = $this->repository->findCategorie();
        $articles = $this->repository->findAll();

        return $this->render('articles/index.html.twig', [
            'current_menu' => 'articles',
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/{slug}", name="articles_show", methods={"GET"} )
     */
    public function show(Articles $article, Request $request, EntityManagerInterface $manager)
    {  
        $comment = new Comment();

//      $form = $this->createForm(CommentType::class, $comment);

        $form = $this->createFormBuilder($comment)
                ->add('auteur')
                ->add('content', CKEditorType::class)
                ->getForm(); 
       
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $comment->setCreatedAt(new \DateTime())
                     ->setArticle($article);
            $manager->persist($comment);

            $manager->flush();

            return $this->redirectToRoute('articles_show',  ['id' => $article->getId()
            ]);
    }
        return $this->render('articles/show.html.twig', [
            'article'=>$article,
//          'comment'=> $comment,
            'commentForm'=> $form->createView()
        ]);
    }
}