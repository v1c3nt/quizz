<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuizzRepository;
use App\Repository\UserCrewRepository;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("/profile/{username}/", name="user_profile")
     */
    public function showProfil(QuizzRepository $quizzes, UserCrewRepository $uCrews)
    {
        $user = $this->getUser();
        $myQuizzes = $quizzes->findByAuthor($user);
        $myCrews = $uCrews->findByUser($user);
        dump($user);
        dump($myQuizzes);
        dump($myCrews);

        return $this->render('user/index.html.twig', [
            'user' => $user,
            'myQuizzes' => $myQuizzes,
            'myCrews' => $myCrews,
        ]);
    }

    /**
     * @Route("/profile/{id}/{username}_edite", name="edit_user_profilee")
     */
    public function editProfil(UserCrewRepository $uCrews, $id, Request $request )
    {
            $user = $this->getUser();
        //? je vérifie que l'id envoyé est bien celui de l'utilisateur connecté.
        if( $user->getId() == $id ) {

            $userModif = new User();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                
                
                return $this->redirectToRoute('user__profile', [
                    'username'=> $user->getUserName(),
                    ]);
                }else{
                    $form->remove('password');

                return $this->render('user/profileEdit.html.twig', [
                    'form'=> $form->createView(),
                    'user'=> $user,
                ]);

            }
        }else{
            return $this->redirectToRoute('home');
        }
        
        return $this->render('user/index.html.twig', [
            'user' => $user,
            'myQuizzes' => $myQuizzes,
            'myCrews' => $myCrews,
        ]);
    }
}
