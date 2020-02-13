<?php

namespace App\Controller;


use App\Entity\Scores;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ScoresRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findVisible();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' =>$articles
        ]);
    }

    /**
     * @Route("/apropos", name="apropos")
     */
    public function apropos()
    {
        
        return $this->render('blog/apropos.html.twig');
    }

    /**
     * @Route("/", name="home")
     */

    public function home( ArticleRepository $articlerepo, ScoresRepository $scorerepo) {
        $scores = $scorerepo->findLatestScore();
        $articles = $articlerepo->findLatest();
        return $this->render('blog/home.html.twig',[
            'scores' =>$scores,
            'articles' =>$articles
        ]);
    }

    
    /**
     * @Route("/blog/new",name="blog_create")
     * @Route("/blog/{id}/edit",name="blog_edit")
     */

    public function form(Article $article = null, Request $request, EntityManagerInterface $manager) {

        if(!$article){
            $article = new Article();
        }
        
        $form = $this->createForm(ArticleType::class, $article);

        $form -> handleRequest($request);

        if($form->isSubmitted() && $form-> isValid()){
            if(!$article->getId()){
                $article->setCreatedAt(new \DateTime());
            }
            $file = $article->getImage();
            $fileName = md5(uniqid().'.'.$file->guessExtension());
            $file->move($this->getParameter('upload_directory'), $fileName);

            $article->setImage($fileName);

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', [
                'id'=> $article->getId(),
                'image'=> $article->getImage()
            ]);
        }
        return $this->render('blog/create.html.twig',[
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }

    /**
     * @Route("/{id}", name="blog_show")
     */

    public function show (Article $article, ArticleRepository $repo) {
        
        $articles = $repo->findVisible();
        return $this->render('blog/show.html.twig',[
            'article' =>$article,
            'articles' =>$articles
            
        ]);
    }

}
