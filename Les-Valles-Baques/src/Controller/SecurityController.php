<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="security_login", methods={"GET","POST"})
     */
    public function login()
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/inscription", name="security_signUp", methods={"GET","POST"})
     */
    public function signUp(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $encodedPassword = $encoder->encodePassword ($user, $user->getPassword());
            $user->setPassword($encodedPassword);
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            exit;
            $em->flush();
            return $this->redirectToRoute('author_index');
        }

        
        return $this->render('security/signup.html.twig',
            ['form' => $form->createView (),
            
            ]);
    }


    
}
