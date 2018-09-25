<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuizzRepository;
use App\Repository\UserCrewRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(QuizzRepository $quizzes, UserCrewRepository $uCrews, SessionInterface $session )
    {
        /**
         * 
         * TODO preparation pour les acces a faire quand role OK
        $login = $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        dump($login);
        $userCrews = $uCrews->findByUser($user->getId());
        dump($userCrews)
        dump($user);
         */
        //

        $quizzes = $quizzes->findAll();

        $new = count($quizzes);

        $newQuizzes[] = $quizzes[$new - 3];
        $newQuizzes[] = $quizzes[$new - 2];
        $newQuizzes[] = $quizzes[$new - 1];

        $randomKey = array_rand($quizzes);
        $randomQuizz = $quizzes[$randomKey];

        return $this->render('home/index.html.twig', [
            'title' => 'Les VallesBaques',
            'newQuizzes' => $newQuizzes,
            'randomQuizz' => $randomQuizz,
        ]);
    }
}
