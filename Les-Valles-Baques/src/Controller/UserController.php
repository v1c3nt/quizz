<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuizzRepository;
use App\Repository\UserCrewRepository;
use App\Repository\StatisticRepository;

class UserController extends AbstractController
{
    /**
     * @Route("/{username}/profile", name="user_profil")
     */
    public function showProfil(QuizzRepository $quizzes, UserCrewRepository $uCrews, StatisticRepository $statRepo)
    {

        $user = $this->getUser();
        $myQuizzes = $quizzes->findByAuthor($user);
        $myCrews = $uCrews->findByUser($user);
        $stats = $statRepo->findByUser($user);

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'myQuizzes' => $myQuizzes,
            'myCrews' => $myCrews,
            'stats' => $stats
        ]);
    }
}
