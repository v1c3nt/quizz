<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuizzRepository;
use App\Repository\UserCrewRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\QuestionRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(QuizzRepository $qr, UserCrewRepository $uCrews, SessionInterface $session)
    {
        $user = $this->getUser();
        /**
         *
         * TODO preparation pour les acces a faire quand role OK
        $login = $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $userCrews = $uCrews->findByUser($user->getId());

         */
        //
        $newQuizzes = $qr->findFourPublicCompleted();
        foreach ($newQuizzes as $key => $quizz) {

            $questions[$key] = $newQuizzes[$key]->getQuestions();
        }
        $randomQuizz = $qr->findRandomPublicCompleted();
        $questions['random'] = $randomQuizz->getQuestions();

        return $this->render('home/index.html.twig', [
            'title' => 'Les VallesBaques',
            'newQuizzes' => $newQuizzes,
            'randomQuizz' => $randomQuizz,
            'questions' => $questions,
        ]);
    }
}
