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
use App\Repository\StatisticRepository;
use App\Entity\Statistic;
use App\Repository\IsLikeRepository;
use App\Entity\IsLike;
use Doctrine\ORM\EntityManager;


class QuizzController extends AbstractController
{

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
     * TODO {id} a changer par slug.
     * @Route("/question/quizz/{id}/{nbr}", name="questions_quizz", methods={"POST|GET"}, defaults={"nbr"=0})
     */
    public function addQuestions(Request $request, ObjectManager $manager, $id, QuestionRepository $questionRepo, Quizz $quizz, $nbr) : Response
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
            $this->addFlash('success', 'Question ' . $nbr . ' ajoutée');
            if ($question->getNbr() > 9) {
                $this->addFlash('primary', 'Question ' . ($nbr - 1) . ' ajoutée! plus que 1 !');
            } elseif ($question->getNbr() > 8) {
                $this->addFlash('primary', 'Question ' . ($nbr - 1) . ' ajoutée! La dernière ligne droite!');
            } elseif ($question->getNbr() > 7) {
                $this->addFlash('primary', 'Question ' . ($nbr - 1) . ' ajoutée! plus que 3!');
            } elseif ($question->getNbr() > 6) {
                $this->addFlash('primary', 'Question ' . ($nbr - 1) . ' ajoutée! Tu as fait la moitié du travail !');
            } elseif ($question->getNbr() > 5) {
                $this->addFlash('primary', 'Question ' . ($nbr - 1) . ' ajoutée! plus que 5!');
            } elseif ($question->getNbr() > 4) {
                $this->addFlash('primary', 'Question ' . ($nbr - 1) . ' ajoutée! encore une et tu es à la moitiée');
            } elseif ($question->getNbr() > 3) {
                $this->addFlash('primary', 'Question ' . ($nbr - 1) . ' ajoutée! plus que 7!');
            } elseif ($question->getNbr() > 2) {
                $this->addFlash('primary', 'Question ' . ($nbr - 1) . ' ajoutée! Encore 8 ça va aller vite courage');
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
    public function play($id, Request $request, QuestionRepository $questionRepo, SessionInterface $session)
    {

        if (null === $session->get('results' . $id . '') || empty($session->get('results' . $id . ''))) {
            $results[] = 'quizz_' . $id;
            $session->set('results' . $id . '', $results);
        }

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
                'id' => $id
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
    public function results($id, QuizzRepository $quizzRepo, ObjectManager $manager, SessionInterface $session, StatisticRepository $statRepo)
    {
        $user = $user = $this->getUser();

        $quizz = $quizzRepo->findOneBy(['id' => $id]);

        $points = 0;
        //? Si la variable results existe en session je récupere la variable stocké en session et je la détruis
        ((null !== $session->get('results' . $id . '')) ? ($answers = $session->remove('results' . $id . '')) : '');
        //$answers = $session->remove('results' . $id . '');

        $results = [];
        //? je boucle sur le tableau en session pour récupérer les réponses puis je le remets a vide.
        foreach ($answers as $key => $answer) {
            $results[] = $answer;

            if ($answer === 'prop1') {
                $points++;
            }

        }

        $stat = new Statistic();
        $stat->setQuizz($quizz);
        $stat->setUser($user);
        $stat->setResult($points);

        $manager->persist($stat);

        $manager->flush();



        return $this->render('quizz/results.html.twig', [
            'answers' => $answers,
            'quizz' => $quizz,
            'points' => $points,
        ]);

    }

    /** 
     * TODO replacer id par slug
     * @Route ("quizz/like_{id}", name = "add_like")
     */
    public function addLike($id, IsLikeRepository $likeRepo, ObjectManager $manager, QuizzRepository $quizzRepo)
    {
        $user = $this->getUser();

        $quizz = $quizzRepo->findOneBy(['id' => $id]);

        $Like = $likeRepo->findOneBy(['quizz' => $id, 'user' => $user->getId()]);
        if ($Like === null) {
            $toogle = 1;
            $Like = new IsLike;
            $Like->setUser($user);
            $Like->setQuizz($quizz);
            $Like->setLikeIt($toogle);
            dump(['null', $toogle]);
        } else {
            
            ( ( true === $Like->getLikeIt() )? $Like->setLikeIt(false): $Like->setLikeIt(true) );

        }
        $manager->persist($Like);
        dump($Like->getLikeIt());
        $manager->flush();

        return $this->redirectToRoute('quizz_list_sort', [
            'sort' => 'title'

        ]);
    }

    /**
     * @Route("/quizz/{sort}", name="quizz_list_sort", defaults={"sort"="title"})
     */
    public function index($sort, IsLikeRepository $likeRepo, CategoryRepository $categories, QuizzRepository $quizzs)
    {
        $likes = $likeRepo->findAll();
        $categories = $categories->findBy([], ['name' => 'ASC']);
        $quizzs = $quizzs->findby([], [$sort => 'DESC']);
        dump($quizzs);
        dump($likes);
        $QuizzLikes = [];
        $quizz = [];
        foreach ($quizzs as $quizz) {
            $count = 0;

                

            
            
        }



        $repository = $this->getDoctrine()->getRepository(Category::class);
        $repositoryQuizz = $this->getDoctrine()->getRepository(Quizz::class);


        return $this->render('quizz/indexbis.html.twig', [
            'categories' => $categories,
            'quizzs' => $quizzs,
            'likes' => $likes,
        ]);
    }

}
                