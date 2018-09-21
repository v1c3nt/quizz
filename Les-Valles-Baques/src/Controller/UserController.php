<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuizzRepository;
use App\Repository\UserCrewRepository;

class UserController extends AbstractController
{
    /**
     * @Route("/{username}/profile", name="user_profil")
     */
    public function showProfil(QuizzRepository $quizzes, UserCrewRepository $uCrews)
    {
        $user = $this->getUser();
        $crews = $user->getUserCrews();
        $myQuizzes = $quizzes->findByAuthor($user);
        $myCrews = $uCrews->findByUser($user);
        dump($user);
        dump($crews);
        dump($myCrews);

        return $this->render('user/index.html.twig', [
            'user' => $user,
            'myQuizzes' => $myQuizzes,
            'crews' => $crews,
            'myCrews' => $myCrews,
        ]);
    }
}
