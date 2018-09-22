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
use Symfony\Component\VarDumper\Server\DumpServer;

class QuizzController extends AbstractController
{
    /**
     * @Route("/quizz/{sort}", name="quizz_list_sort", defaults={"sort"="title"})
     */
    public function index($sort)
    {
        $user = $this->getUser();

        $repository = $this->getDoctrine()->getRepository(Category::class);
        $repositoryQuizz = $this->getDoctrine()->getRepository(Quizz::class);

        $categories = $repository->findBy([], ['name' => 'ASC']);
        $quizzs = $repositoryQuizz->findby(['isPrivate'=> 0], [$sort => 'DESC']);
        

        dump($quizzs);
        foreach ($quizzs as $key => $quizz) {
           
            if ( 0 === $quizz->getCrew() ){
                dump('if');
            }

        }

        return $this->render('quizz/indexbis.html.twig', [
            'categories' => $categories,
            'quizzs' => $quizzs,
        ]);
    }

    /**
     * @Route("/quizz/show/{id}", name="quizz_show")
     */
    public function show(Quizz $quizz ) : Response
    {
        $question = $quizz->getQuestions();

        return $this->render('quizz/show.html.twig', [
            'quizz' => $quizz,
            'questions' => $question
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
            //TODO ajouter l'id du groupe du user 
            
            // TODO ajouter un slugger
            $quizz->setSlug('test');
            // TODO comment géer la partie privée si l'utilisateur a plusieurs crew ?
            dump($user);
            //  $quizz->setCrew('user.crew')
            $manager->persist($quizz);
            $manager->flush();
            dump($request);
            

            //? après la création du questionnaire j'oriente vers la  création des questions.
            return $this->redirectToRoute('questions_quizz', [
                'id' => $quizz->getId(),
                'quizz' => $quizz,
                'nbr' => 0,
            ]);
        }

        return $this->render('quizz/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * TODO {id} a changer par slug.
     * @Route("/question/quizz/{id}/{nbr}", name="questions_quizz", methods={"POST|GET"}, defaults={"nbr"=0})
     */
    public function addQuestions(Request $request, ObjectManager $manager, $id, QuestionRepository $questionRepo , Quizz $quizz, $nbr) : Response
    {
   
        $question = new Question();

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);
        
        $questions = $questionRepo->findBy(['quizz' => $quizz->getId()]);
        if ($form->isSubmitted() && $form->isValid()) {

            //? je crée une variable pour compter le nombre de questions créées
            $nbr++;
            $question->setQuizz($quizz);
            $question->setErrore(0);
            $question->setNbr($nbr);
            $manager->persist($question);
            
            $manager->flush();
            $this->addFlash('success', 'Question '.$nbr.' ajoutée');
            if ( $question->getNbr() > 9) {
                $this->addFlash('primary', 'Question ' .( $nbr - 1 ). ' ajoutée! plus que 1 !'); 
            } elseif ($question->getNbr() > 8) {
                $this->addFlash('primary', 'Question ' .( $nbr - 1 ). ' ajoutée! La dernière ligne droite!');
            } elseif ($question->getNbr() > 7) {
                $this->addFlash('primary', 'Question ' .( $nbr - 1 ). ' ajoutée! plus que 3!');
            } elseif ($question->getNbr() > 6) {
                $this->addFlash('primary', 'Question ' .( $nbr - 1 ). ' ajoutée! Tu as fait la moitié du travail !');
            } elseif ($question->getNbr() > 5) {
                $this->addFlash('primary', 'Question ' .( $nbr - 1 ). ' ajoutée! plus que 5!');
            } elseif ($question->getNbr() > 4) {
                $this->addFlash('primary', 'Question ' .( $nbr - 1 ). ' ajoutée! encore une et tu es à la moitiée');
            } elseif ($question->getNbr() > 3) {
                $this->addFlash('primary', 'Question ' .( $nbr - 1 ). ' ajoutée! plus que 7!');
            } elseif ($question->getNbr() > 2) {
                $this->addFlash('primary', 'Question ' .( $nbr - 1 ) . ' ajoutée! Encore 8 ça va aller vite courage');
            } elseif ($question->getNbr() > 1) {
                $this->addFlash('primary', 'Question ' . $nbr . ' ajoutée! plus que 9!');
            
            
            
            }


            $questions = $questionRepo->findBy(['quizz' => $id]);
            
            if ($nbr < 10) {

                return $this->redirectToRoute('questions_quizz', [
                    'id' => $quizz->getId(),
                    'quizz' => $quizz,
                    'nbr' => $nbr,
                    'questions' => $questions,
                ]);

            }

            return $this->redirectToRoute('quizz_list_sort', [
                'sort ' => 'id'
            ]);
        }

        return $this->render('quizz/newsQuestions.html.twig', [
            'form' => $form->createView(),
            'quizz' => $quizz,
            'nbr' => $nbr,
            'questions' => $questions,
        ]);
    }

  /**
     * TODO replacer id par slug
     * a voir pour bloqué l
     * @Route("quizz_{id}/question_{nbr}", name="quizz_play")
     * 
     */
    public function play($id, Quizz $quizz, Request $request, $nbr, QuestionRepository $questionRepo)
    {

        $question = $questionRepo->findBy(['quizz'=>$id, 'nbr'=> $nbr]);
        dump($question);
        $user = $this->getUser();
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        $questions =$quizz->getQuestions();
        dump($questions);
        $play = $question->getNbr();

        dump($play);exit;
        if ($form->isSubmitted() && $form->isValid()) { }
    }
}
