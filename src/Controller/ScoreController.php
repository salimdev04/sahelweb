<?php

namespace App\Controller;

use App\Entity\Scores;
use App\Form\ScoreType;
use App\Repository\ScoresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ScoreController extends AbstractController
{
    /**
     * @Route(".../score", name="score")
     */
    public function index(Scores $score=null , Request $request, EntityManagerInterface $manager)
    {
        if(!$score){
            $score = new Scores();
        }
        $formScore = $this->createForm(ScoreType:: class, $score);
        $formScore ->handleRequest($request);

        if($formScore-> isSubmitted() && $formScore-> isValid()){

            $manager-> persist($score);
            $manager->flush();


            return $this->redirectToRoute('home');
        }
        return $this->render('score/index.html.twig', [
            'formScore'=> $formScore->createView(),
            'controller_name' => 'ScoreController',
        ]);
    }

    /**
     * @Route(".../score/showscore", name="showscore")
     */

    public function showscore(ScoresRepository $repo){

        $scores = $repo->findLatestScore();
        return $this->render('score/showscore.html.twig',[
            'scores'=>$scores
        ]);

    }
}
