<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuizzRepository;

class QuizzController extends AbstractController
{
    /**
     * @Route("/quizz", name="quizz_list")
     */
    public function show(QuizzRepository $quizzes)
    {
        $quizzes = $quizzes->findAll();
        dump($quizzes);

        return $this->render('quizz/show.html.twig', [
            'quizzes'=>$quizzes
        ]);
    }
}
