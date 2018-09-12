<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuizzRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(QuizzRepository $quizzes)
    {
        $quizzes = $quizzes->findAll();

        $new = count($quizzes);
        
        $newQuizzes[] = $quizzes[$new - 3];
        $newQuizzes[] = $quizzes[$new - 2];
        $newQuizzes[] = $quizzes[$new - 1];

        $randomKey = array_rand($quizzes);
        $randomQuizz = $quizzes[$randomKey];
        dump($randomQuizz);

        /**
         * ?test avec une seule requete
         *
         *
        $newQuizzes = $quizzes->findBy(
            [],
            ['id' => 'DESC'],
            3
            );

         */


        return $this->render('home/index.html.twig', [
            'title' => 'Les VallesBaques',
            'newQuizzes' => $newQuizzes,
            'randomQuizz' => $randomQuizz,
        ]);
    }
}
