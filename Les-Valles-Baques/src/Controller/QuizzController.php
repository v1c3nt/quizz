<?php

namespace App\Controller;

use App\Entity\Crew;
use App\Entity\Quizz;
use App\Entity\IsLike;
use App\Form\CrewType;
use App\Form\QuizzType;
use App\Entity\Category;
use App\Entity\Question;
use App\Service\Slugger;
use App\Entity\Statistic;
use App\Entity\CrewQuizzs;
use App\Form\QuestionType;
use App\Form\CrewQuizzsType;
use Doctrine\ORM\EntityManager;
use App\Repository\CrewRepository;

use App\Repository\QuizzRepository;
use App\Repository\IsLikeRepository;
use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use App\Repository\UserCrewRepository;
use App\Repository\StatisticRepository;
use App\Repository\CrewQuizzsRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Session\Session;
use ProxyManager\ProxyGenerator\Util\PublicScopeSimulator;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use App\Repository\UserRepository;

class QuizzController extends AbstractController
{

    /**
     * @Route("/quizz/show/{slug}", name="quizz_show")
     */
    public function show(Quizz $quizz = null) : Response
    {
        $question = $quizz->getQuestions();

        if (!$question) {
            throw $this->createNotFoundException('Il n\'y a aucun Quizz par ici.');
        }


        return $this->render('quizz/show.html.twig', [
            'quizz' => $quizz,
            'questions' => $question,
        ]);
    }

    /**
     * @Route("/quizz/propose/nouveau", name="new_quizz")
     */
    public function new(Request $request, ObjectManager $manager, UserCrewRepository $ucr, CrewQuizzsRepository $cqr, CrewRepository $crewRepo, Slugger $slugger)
    {
        $user = $this->getUser();

        //? Si l'utilisateur n'as pas de quizz en cours de création alors j'affiche le formulaire de création.
        $quizzInProgress = $this->getDoctrine()->getRepository(Quizz::class)->findInProgress($user);
        if ( null === $quizzInProgress ){

            $crews = $ucr->findBy(['user' => $user]);
            $crew = $crewRepo->findAll();
            $quizz = new Quizz();

            $form = $this->createForm(QuizzType::class, $quizz);
            $crewsChoices[] = ['publique' => null];
  
            //? je boucle sur les crews de l'utilisateur et je les ajoute dans le tableau crewsChoices
            foreach ($crews as $crew) {
                $crewsChoices[] = [$crew->getCrew()->getName() => $crew->getCrew()];
            }
            $form->add('arrayCrew', choiceType::class, [
                'choices' => [
                    $crewsChoices
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'visibilité',// être plus explicite
                'help' => 'Choisi "Publique" pour que ton quizz soit visible par tous ou choisi un ou plusieurs groupes.'
            ]);


            $form->handleRequest($request);
            //? j'ajoute le User connecté comme auteur du quizz
            if ($form->isSubmitted() && $form->isValid()) {
                $quizz->setAuthor($user);
                $arrayCrews = $quizz->getArrayCrew();
            //? si le tableau contient ne contient pas NULL, il est donc privée.
                (true !== (in_array(null, $arrayCrews))) ? $quizz->setIsPrivate(1) : $quizz->setIsPrivate(0);

            //TODO ajouter l'id du groupe du user

                $convertedTitle = $slugger->slugify($quizz->getTitle());
                $quizz->setSlug($convertedTitle);
                
           
            //  $quizz->setCrew('user.crew')
                $manager->persist($quizz);

                $manager->flush();

                if (true === $quizz->getIsPrivate()) {
                    foreach ($arrayCrews as $crew) {
                        $quizzAutho = new CrewQuizzs;
                        $authorization = $quizzAutho->setCrew($crew);
                        $authorization = $quizzAutho->setQuizz($quizz);

                        $manager->persist($authorization);
                        $manager->flush();
                    }
                }
             
            //? après la création du questionnaire j'oriente vers la  création des questions.
                return $this->redirectToRoute('questions_quizz', [
                    'id' => $quizz->getId(),
                    'slug' => $quizz->getSlug(),
                    'quizz' => $quizz,
                    'nbr' => 0,
                ]);
            }

            return $this->render('quizz/new.html.twig', [
                'form' => $form->createView()
            ]);

        }

        return $this->redirectToRoute('quizz_creat_inprogress', [
           
        ]);
    }

    /**
     * @Route("/quizz_encours_de_creation", name="quizz_creat_inprogress")
     */
    public function QuizzInProgress(QuestionRepository $qr)
    {
        $user = $this->getUser();

        //? Si l'utilisateur n'as pas de quizz en cours de création alors j'affiche le formulaire de création.
        $quizzInProgress = $this->getDoctrine()->getRepository(Quizz::class)->findInProgress($user);
        $questions = [];
        dump($quizzInProgress);

        foreach ($quizzInProgress as $key => $quizz) {
            $id = $quizz->getId();
            $questions[$id] = $qr->findQuestionsByIdQuizz($id);
        }
        
        return $this->render('quizz/inprogress.html.twig', [
            'quizzs' => $quizzInProgress,
            'questions' => $questions,
        ]);

    }


    /**
     * TODO {id} a changer par slug.
     * @Route("/question/{nbr}/quizz/{id}/{slug}", name="questions_quizz", methods={"POST|GET"}, defaults={"nbr"=0})
     */
    public function addQuestions(Request $request, ObjectManager $manager, $id, QuestionRepository $questionRepo, Quizz $quizz, $nbr, $slug, QuizzRepository $qr) : Response
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
            $question->setNbr($nbr);;

            $manager->persist($question);
            $manager->flush();

            //? addFlash ajout de question
            if ($question->getNbr() > 9) {
                $this->addFlash('primary', 'Question ' . ($nbr) . ' ajoutée! Courage la dernière !');
            } elseif ($question->getNbr() > 8) {
                $this->addFlash('primary', 'Question ' . ($nbr) . ' ajoutée! La dernière ligne droite!');
            } elseif ($question->getNbr() > 7) {
                $this->addFlash('primary', 'Question ' . ($nbr) . ' ajoutée! plus que 2!');
            } elseif ($question->getNbr() > 6) {
                $this->addFlash('primary', 'Question ' . ($nbr) . ' ajoutée! ');
            } elseif ($question->getNbr() > 5) {
                $this->addFlash('primary', 'Question ' . ($nbr) . ' ajoutée! ');
            } elseif ($question->getNbr() > 4) {
                $this->addFlash('primary', 'Question ' . ($nbr) . ' ajoutée! Tu as fait la moitié du travail !');
            } elseif ($question->getNbr() > 3) {
                $this->addFlash('primary', 'Question ' . ($nbr) . ' ajoutée! plus que 6!');
            } elseif ($question->getNbr() > 2) {
                $this->addFlash('primary', 'Question ' . ($nbr) . ' ajoutée! Encore 7 ça va aller vite courage');
            } elseif ($question->getNbr() > 1) {
                $this->addFlash('primary', 'Question ' . $nbr . ' ajoutée! plus que 8!');
            }

            $questions = $questionRepo->findBy(['quizz' => $id]);
            if ($nbr < 10) {
                return $this->redirectToRoute('questions_quizz', [
                    'id' => $quizz->getId(),
                    'quizz' => $quizz,
                    'nbr' => $nbr,
                    'questions' => $questions,
                    'slug' => $slug,
                ]);
            }

            $now = new \DateTime();
            $quizz->setCompletedAt($now);
            $manager->flush();

            return $this->redirectToRoute('quizz_list_sort', [
                'sort ' => 'id'
            ]);
        }

        return $this->render('quizz/newsQuestions.html.twig', [
            'form' => $form->createView(),
            'quizz' => $quizz,
            'nbr' => $nbr,
            'questions' => $questions,
            'slug' => $slug,
        ]);
    }

    /**
     * TODO replacer id par slug
     * a voir pour bloqué l
     * @Route("quizz_{id}/{slug}/question_{nbr}", name="quizz_play", defaults={"nbr"=1})
     *
     */
    public function play($id, $slug, Request $request, QuestionRepository $questionRepo, SessionInterface $session)
    {
        if (null === $session->get('results' . $id . '') || empty($session->get('results' . $id . '')) || 11 === count($session->get('results' . $id . ''))) {
            $results[] = 'quizz_' . $id;
            $session->set('results' . $id . '', $results);
        }

        $nbr = count($session->get('results' . $id . ''));

        $user = $this->getUser();
        $question = $questionRepo->findOneBy(['quizz' => $id, 'nbr' => $nbr]);
        $responses[] =
            [$question->getProp1() => 'prop1'];
        $responses[] =
            [$question->getProp2() => 'prop2'];
        $responses[] =
            [$question->getProp3() => 'prop3'];
        $responses[] =
            [$question->getProp4() => 'prop4'];
        shuffle($responses);


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
                    'slug' => $slug,
                ]);
            }

            return $this->redirectToRoute('quizz_results', [
                'id' => $id,
                'slug' => $slug,
            ]);
        }

        return $this->render('quizz/play.html.twig', [
            'form' => $form->createView(),
            'nbr' => $nbr,
            'question' => $question,
        ]);
    }

    /**
     * TODO replacer id par slug
     * a voir pour bloqué l
     * @Route("resultats/quizz_{id}/{slug}", name="quizz_results")
     *
     */
    public function results($id, $slug, QuizzRepository $quizzRepo, ObjectManager $manager, SessionInterface $session, StatisticRepository $statRepo)
    {
        $user = $user = $this->getUser();

        $quizz = $quizzRepo->findOneBy(['id' => $id]);

        $points = 0;
        $congrats = "";
        
        //? Si la variable results existe en session je récupere la variable stocké en session et je la détruis
        ((null !== $session->get('results' . $id . '')) ? ($answers = $session->get('results' . $id . '')) : '');
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
        $stat->setAnswers($answers);

        $manager->persist($stat);
        $manager->flush();

        $quizz = $quizzRepo->findOneBy(['id' => $id]);
        $avg = $statRepo->avgResultByQuizz($id)[0]['AVG(result)'];

        $quizz->setAvgScore($avg);

        $manager->persist($quizz);

        $manager->flush();

        if (10 === $points) {
            $congrats = 'Alors là tu me bluffes, Bravo !';
        } elseif (8 <= $points) {
            $congrats = 'Mention très bien !';
        } elseif (6 <= $points) {
            $congrats = 'Pas mal !';
        } elseif (5 === $points) {
            $congrats = 'Juste la moyenne.';
        } elseif (3 <= $points) {
            $congrats = 'C\'est vraiment trop... juste, il faut réviser.';
        } else {
            $congrats = 'A ce niveau-là, ce n\'est plus de la révision !';
        }

        return $this->render('quizz/results.html.twig', [
            'answers' => $answers,
            'quizz' => $quizz,
            'points' => $points,
            'slug' => $slug,
            'congrats' => $congrats,
        ]);
    }


    /**
     * @Route("/quizz/{sort}", name="quizz_list_sort", defaults={"sort"="title"})
     */
    public function index($sort, CategoryRepository $categories, QuizzRepository $quizzs, StatisticRepository $statRepo)
    {
        $user = $this->getUser();
        $categories = $categories->findBy([], ['name' => 'ASC']);
        $quizzsAll = $quizzs->findBy(['isPrivate' => 0], [$sort => 'DESC']);
        $stats = $statRepo->findByUser($user);
        $myScores = [];
        $quizzs = [];

        foreach ($quizzsAll as $quizz) {
            ($quizz->getCompletedAt() !== null) ? $quizzs[] = $quizz : "";
        }
        foreach ($quizzs as $key => $quizz) {
            $idQ = $quizz->getId();

            $myScores[$idQ] = $statRepo->avgResultByQuizz($idQ)[0]['AVG(result)'];
        }

        return $this->render('quizz/quizzsList.html.twig', [
            'categories' => $categories,
            'quizzs' => $quizzs,
            'myScores' => $myScores,
        ]);
    }

<<<<<<< HEAD
=======
    /**
     * @route("/quizz/{id}/{slug}/supprimer", name="quizz_delete" )
     */
    public function deleteCrew($id, QuizzRepository $qr )
    {
        $userActive = $this->getUser();
        $quizz = $qr->findOneById($id);
        
        /**
         * ? Si l'utilisateur connecté a bien les droit d'ajout j'ajoute le membre.
         */
        if ( $userActive === $quizz->getAuthor() ) {
           
            $em = $this->getDoctrine()->getManager();
            $em->remove($quizz);
            $em->flush();



            return $this->redirectToRoute('crews_show');
        }

        return $this->redirectToRoute('crews_show');
    }


>>>>>>> continueQuizz
}
