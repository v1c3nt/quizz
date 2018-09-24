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
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use ProxyManager\ProxyGenerator\Util\PublicScopeSimulator;


class QuizzController extends AbstractController
{
    /**
     * @Route("/quizz/{sort}", name="quizz_list_sort", defaults={"sort"="title"})
     */
    public function index($sort)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $repositoryQuizz = $this->getDoctrine()->getRepository(Quizz::class);

        $categories = $repository->findBy([], ['name' => 'ASC']);
        $quizzs = $repositoryQuizz->findby([], [$sort => 'DESC']);

        return $this->render('quizz/indexbis.html.twig', [
            'categories' => $categories,
            'quizzs' => $quizzs,
        ]);
    }

    /**
     * @Route("/quizz/show/{id}", name="quizz_show")
     */
    public function show(Quizz $quizz) : Response
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
     * @Route("/question/quizz/{id}/{nbr}", name="questions_quizz", methods="POST|GET", defaults={"nbr"=0})
     */
    public function addQuestions(Request $request, ObjectManager $manager, $id, QuestionRepository $questionRepo, Quizz $quizz, $nbr) : Response
    {
        $question = new Question();

        //? je récupere l'id du quizz créer

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);
        //? je crée une variable pour compter le nombre de question créées

        if ($form->isSubmitted() && $form->isValid()) {
            $nbr++;
            $question->setQuizz($quizz);
            $question->setErrore(0);
            $question->setNbr($nbr);
            $manager->persist($question);

            $manager->flush();

            $questions = $questionRepo->findBy(['quizz' => $id]);

            if ($nbr <= 10) {
                $question = new Question();
                dump($questions);
                $form = $this->createForm(QuestionType::class, $question);
                return $this->render('quizz/newsQuestions.html.twig', [
                    'nbr' => $nbr,
                    'form' => $form->createView(),
                    'quizz' => $quizz,
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
        ]);
    }
    
    /**
     * TODO replacer id par slug
     * a voir pour bloqué l
     * @Route("quizz_{id}/question_{nbr}", name="quizz_play")
     *
     */
    public function play($id, Request $request, QuestionRepository $questionRepo, SessionInterface $session)
    {
       
        if ( null === $session->get('results' . $id . '') || empty($session->get('results' . $id . '')) ){
            $results[] = 'quizz_'. $id;
            $session->set('results' . $id . '', $results);
        } 
     
        dump($session->get('results' . $id . ''));
        $nbr = count($session->get('results' . $id . ''));

        $user = $this->getUser();

        $question = $questionRepo->findOneBy(['quizz' => $id, 'nbr' => $nbr]);

        $responses = [
            $question->getProp1() => 'prop1',
            $question->getProp2() => 'prop2',
            $question->getProp3() => 'prop3',
            $question->getProp4() => 'prop4'
        ];


        $form = $this->createFormBuilder()
            ->add('responses', ChoiceType::class, [
                'label' => $question->getBody(),
                'choices' => $responses,
                'expanded' => true,
                'multiple' => false,
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ici le fait de passer dans le if ça bloque la récup des autres réponses
            // on arrive a afficher les 10 Questions av ec les réponses mais dans le form->getData() qu'une seule requête affichée
            // dans le tableau
            $nbr++;
            
            $answers = $session->get('results' . $id . '');
            $answer = $form->getData()['responses'];
            array_push($answers, $answer);
            $session->set('results' . $id . '', $answers);
            
            if ($nbr <= 10) {

                return $this->redirectToRoute('quizz_play', [
                    'question' => $question,
                    'nbr' => $nbr,
                    'id' => $id,
                ]);
            }

            //! redirectToRoute resultat
            return $this->redirectToRoute('quizz_results', [
                'id'=>$id
            ]);

        }

        return $this->render('quizz/play.html.twig', [
            'form' => $form->createView(),
            'question' => $question,
        ]);
    }

    /**
     * TODO replacer id par slug
     * a voir pour bloqué l
     * @Route("resultats/quizz_{id}", name="quizz_results")
     *
     */
    public function results ($id, QuizzRepository $quizzRepo, SessionInterface $session)
    {
        $quizz = $quizzRepo->findOneBy(['id'=>$id]);

        $points = 0;
        $answers = $session->get('results' . $id . '');
        dump($answers);
        $results = [];
        //? je boucle sur le tableau en session pour récupérer les réponses puis je le remets a vide.
        foreach ($answers as $key => $answer) {
            $results[] = $answer;
            
            if ( $answer === 'prop1' ){
                $points++;
            }
            
        }
        dump($results);
        dump($points);
   
        //$answers = $session->remove('results' . $id . '');

        //! TODO requetcustom pour optimisation
        return $this->render('quizz/results.html.twig', [
            'answers'=> $answers,
            'quizz'=> $quizz,
            'points'=>$points,
        ]);

    }


}
                