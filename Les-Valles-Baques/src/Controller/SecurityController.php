<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="security_login", methods={"GET","POST"})
     */
    public function login()
    {
        return $this->render('security/login.html.twig');
    }
}
