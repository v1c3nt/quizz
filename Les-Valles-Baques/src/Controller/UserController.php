<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\ChangePasswordType;
use App\Form\Model\ChangePassword;
use App\Repository\UserRepository;
use App\Repository\QuizzRepository;
use App\Repository\UserCrewRepository;
use App\Repository\StatisticRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/profile/{username}/", name="user_profile")
     */
    public function showProfil(QuizzRepository $quizzes, UserCrewRepository $uCrews, StatisticRepository $statRepo)
    {
        //TODO requetCustom !!
        $user = $this->getUser();
        dump($user);

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
     * @Route("/profile/{id}/{username}_edite", name="edit_user_profile", methods="GET|POST")
     */
    public function editProfil(User $user, $id, Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getUser();
        $oldAvatar = $user->getAvatar();
        dump($oldAvatar);
        $form = $this->createForm(UserType::class, $user);
        $form->remove('userName');
        $form->remove('password');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (null === $user->getAvatar()) {
                $user->setAvatar($oldAvatar);
            } else {
                $file = $user->getAvatar();
                $fileName = md5(uniqid()).".".$file->guessExtension();
                $file->move($this->getParameter('avatar_directory'), $fileName);
                $user->setAvatar($fileName);
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('user_profile', [
                'username' => $user->getUserName(),
            ]);
        }
        return $this->render('user/profileEdit.html.twig', [
                    'form'=> $form->createView(),
                    'user'=> $user,
                ]);
    }

    /**
     * @Route("/profile/{id}/{username}_edite_mot_de_passe", name="edit_password", methods="GET|POST")
     ** A revoir pour édition car finalement logout erreur fichier non trouvé lors de l'envoie + pas de changement de mot de passe
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->remove('avatar');
        $form->remove('userName');
        $form->remove('email');
        $form->remove('presentation');


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_profile', [
                    'username'=>$user->getUserName(),
                    ]);
        }

        return $this->render('user/changePassword.html.twig', array(
            'form' => $form->createView(),
            'user'=>$user
        ));
    }
}
