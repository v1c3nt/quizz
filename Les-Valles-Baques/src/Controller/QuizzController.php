<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Form\QuizzType;
use App\Entity\Category;
use App\Entity\Question;
use App\Form\QuestionType;
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

        $categories = $repository->findBy([], ['name' => 'ASC']);
<<<<<<< HEAD
        $quizzs = $repositoryQuizz->findby([], [$sort => 'DESC']);
=======
        $quizzs = $repositoryQuizz->findby([], [$sort => 'ASC']);
>>>>>>> 14007bf7e00e38a05ae7505762003498b1d168d9

        return $this->render('quizz/indexbis.html.twig', [
            'categories' => $categories,
            'quizzs' => $quizzs,
        ]);
    }

    /**
     * @Route("/quizz/show/{id}", name="quizz_list_show")
     */
    public function show(Quizz $quizz) : Response
    {
        return $this->render('quizz/show.html.twig', [
            'quizz' => $quizz,
        ]);
    }

    /**
     * @Route("/quizz/propose/nouveau", name="new_quizz")
     */
    public function new(Request $request, ObjectManager $manager)
    {
        $user = $this->getUser();
        $quizz = new Quizz();

        $form = $this->createForm(QuizzType::class, $quizz);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //? j'ajoute le User connecté comme auteur du quizz
            $quizz->setAuthor($user);
<<<<<<< HEAD
            // TODO ajouter un slugger
=======
            // TODO qjouter un slugger
>>>>>>> 14007bf7e00e38a05ae7505762003498b1d168d9
            $quizz->setSlug('test');
            // TODO comment géer la partie privée si l'utilisateur a plusieurs crew ?
            dump($user); 
            //$quizz->setCrew('user.crew')
            $manager->persist($quizz);
            $manager->flush();

            //? après la création du questionnaire j'oriente vers la  création des questions.
            return $this->redirectToRoute('questions_quizz', [
                'id' => $quizz->getId(),
                'quizz' => $quizz,
            ]);
        }

        return $this->render('quizz/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/question/quizz/{id}/{nbr}", name="questions_quizz", defaults={"nbr"=0})
     */
    public function addQuestions(Request $request, ObjectManager $manager, $id, QuizzRepository $qr, $nbr) : Response
    {

        $question = new Question();
        //? je récupere l'id du quizz créer
        $quizz = $qr->findOneById($id);

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);
        //? je crée une variable pour compter le nombre de question créées
        dump($nbr);
        $nbr ++;
        if ($form->isSubmitted() && $form->isValid()) { 

            $question->setBody('');
            $question->setProp1('');
            $question->setQuizz($quizz);
            $question->setErrore(0);
            dump($nbr);
            $manager->persist($question);
            
            $manager->flush();
            
            if ($nbr < 10) {

                return $this->render('quizz/newsQuestions.html.twig', [
                    'form' => $form->createView(),
                    'quizz' => $quizz,
                    'nbr'=>$nbr,
                ]);

            }

            return $this->redirectToRoute('quizz_list_sort', [
                'sort' => 'id'
            ]);
        }

        return $this->render('quizz/newsQuestions.html.twig', [
            'form' => $form->createView(),
            'quizz' => $quizz,
            'nbr' => $nbr,
        ]);

    }
}