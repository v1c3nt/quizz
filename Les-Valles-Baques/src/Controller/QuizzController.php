<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Entity\Category;
use App\Entity\Question;
use App\Repository\QuizzRepository;
use App\Repository\QuestionRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuizzController extends AbstractController
{
    /**
     * @Route("/quizz/{sort}", name="quizz_list")
     */
    public function index($sort = 'title')
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $repositoryQuizz = $this->getDoctrine()->getRepository(Quizz::class);
        
        $categories = $repository->findBy([], ['name'=>'ASC']);
        $quizzs = $repositoryQuizz->findby([], [$sort=>'ASC']);

        return $this->render('quizz/indexbis.html.twig', [
            'categories'=> $categories,
            'quizzs'=>$quizzs,
        ]);
    }

    /**
     * @Route("/quizz/show/{id}", name="quizz_list_show")
     */
    public function show(Quizz $quizz): Response
    {
        return $this->render('quizz/show.html.twig', [
            'quizz'=>$quizz,
        ]);
    }
}
