<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\AppRoleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_signup", methods={"GET","POST"})
     */
    public function signUp(Request $request, UserPasswordEncoderInterface $encoder, AppRoleRepository $repository, \Swift_Mailer $mailer): Response
    {
        dump($this);
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //? si l'utilisateur n'est pas enregister le lui donne par défault:
            if (null === $user->getId()) {
                //? AppRole id = 2 donc ROLE_USER
                $role = $repository->findOneBy(['id' => 2]);
                dump($role);
                $user->setAppRole($role);
                //? et le status Actif
                $user->setIsActif(true);
            }
            $encodedPassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            $em->flush();

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->container->get('security.token_storage')->setToken($token);
            $this->container->get('session')->set('_security_main', serialize($token));

            //Ici mettre mail validation inscription
            $message = (new \Swift_Message('Validation de l\'inscription'.' '.$user->getUserName())) // ajout de $user->getUserName
                    ->setFrom(array('vivioclock@gmail.com'=> 'Les VallesBaques')) //provenance du mail
                    ->setTo($user->getEmail()) //destinataire email
                    ->setCharset('utf-8')
                    ->setBody(
                    $this->renderView(
                // templates/emails/registration.html.twig
                        'security/emails/registration.html.twig',
                        [
                            'user'=>$user
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);



            return $this->redirectToRoute('home');
        }

        
        return $this->render(
        
            'security/signup.html.twig',
            ['form' => $form->createView(),
            
            ]
        
        );
    }

    /**
     * @Route("/connexion", name="security_login", methods={"GET","POST"})
     */
    public function login()
    {
        return $this->render('security/login.html.twig');
    }
}
