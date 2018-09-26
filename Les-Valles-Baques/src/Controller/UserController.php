<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuizzRepository;
use App\Repository\UserCrewRepository;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\StatisticRepository;
use App\Form\EditUserType;
use App\Repository\UserRepository;


class UserController extends AbstractController
{
    /**
     * @Route("/profile/{username}/", name="user_profile")
     */
    public function showProfil(QuizzRepository $quizzes, UserCrewRepository $uCrews, StatisticRepository $statRepo)
    {
        //TODO requetCustom !!
        $user = $this->getUser();
        $crews = $user->getUserCrews();
        $myQuizzes = $quizzes->findByAuthor($user);
        $myCrews = $uCrews->findByUser($user);
        $stats = $statRepo->findByUser($user);

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'myQuizzes' => $myQuizzes,
            'myCrews' => $myCrews,
            'myStats' => $stats
        ]);
    }

    /**
     * @Route("/profile/{id}/{username}_edite", name="edit_user_profile")
     */
    public function editProfil(User $user, Request $request)
    {
       
        //? je vérifie que l'id envoyé est bien celui de l'utilisateur connecté.
       
            /** 
            *$oldUserName = $user->getUserName();            
            *$oldPassword = $user->getPassword();
            *$oldAvatar = $user->getAvatar();
            *$oldPresentation = $user->getPresentation();
            *$oldEmail = $user->getEmail();            
             */
        
            
            $form = $this->createForm(UserType::class, $user);
            $form->remove('UserName');
            $form->remove('PassWord');

            /** 
            *$user->setUserName($oldUserName);
            *$user->setPassword($oldPassword);
             */
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /**
                *$user->setAvatar($oldAvatar);
                *$user->setEmail($oldEmail);
                *$user->setPresentation($oldPresentation);
                 */
                return $this->redirectToRoute('user__profile', [
                    'username' => $user->getUserName(),
                ]);
            } else {

                return $this->render('user/profileEdit.html.twig', [
                    'form' => $form->createView(),
                    'user' => $user,
                ]);

            }
       
    }
}
