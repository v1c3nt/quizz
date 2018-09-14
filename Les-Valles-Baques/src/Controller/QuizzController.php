<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Form\QuizzType;
use App\Entity\Category;
use App\Entity\Question;
use App\Repository\QuizzRepository;
use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuizzController extends AbstractController
{
    /**
     * @Route("/quizz/{sort}", name="quizz_list_sort")
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
     * @Route("/quizz/liste/{id}", name="quizz_list_show")
     */
    public function show(Quizz $quizz): Response
    {
        return $this->render('quizz/show.html.twig', [
            'quizz'=>$quizz,
        ]);
    }

    /**
     * @Route("/quizz/propose/nouveau", name="quizz_list_new")
     */
    public function new(Request $request, ObjectManager $manager)
    {
        $quizz = new Quizz();
        
        $form = $this->createForm(QuizzType::class, $quizz);

        if ($form->isSubmitted() && $form->isValid()) {
            $question->setAuthor($this->getAuthor());

            $manager->persist($question);
            $manager->flush();
        }
        $form->handleRequest($request);

        return $this->render('quizz/new.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
