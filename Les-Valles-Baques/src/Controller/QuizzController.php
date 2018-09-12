<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Entity\Question;
use App\Repository\QuizzRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\QuestionRepository;

class QuizzController extends AbstractController
{
    /**
     * @Route("/quizz", name="quizz_list")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Quizz::class);
        $quizzes = $repository->findByCategory();
        dump($quizzes);
        return $this->render('quizz/index.html.twig', [
            'quizzes'=>$quizzes
        ]);
    }

    /**
     * @Route("/quizz/{id}", name="quizz_show")
     */
    public function show(Quizz $quizz): Response
    {
        return $this->render('quizz/show.html.twig', [
            'quizz'=>$quizz,
        ]);
    }
}
