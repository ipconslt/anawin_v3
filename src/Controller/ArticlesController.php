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
use Knp\Component\Pager\PaginatorInterface;

USE FOS\CKEditorBundle\Form\Type\CKEditorType;


/**
 * @Route("/articles", name="articles_")
 */
class ArticlesController extends AbstractController
{
    public function __construct(ArticlesRepository $repository){
        $this->repository=$repository;
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        #$articles = $this->repository->findCategorie();
        #$articles = $this->repository->findAll();
        $articles = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
           4 /*limit per page*/
        );

        return $this->render('articles/index.html.twig', [
            'current_menu' => 'articles',
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/{slug}-{id}", name="show", methods={"GET"},requirements={"slug":"[a-z0-9\-]*"} )
     * @param  Articles $articles
     */
    public function show(Articles $articles, string $slug, Request $request, EntityManagerInterface $manager)
    {  
        if($articles->getSlug() !==$slug){
            return $this->redirectToRoute('articles_show',
            ['id'=>$articles->getId(),
            'slug'=>$articles->getslug()],
            301);
        }

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
            'articles'=>$articles,
//          'comment'=> $comment,
            'commentForm'=> $form->createView()
        ]);
    }
}