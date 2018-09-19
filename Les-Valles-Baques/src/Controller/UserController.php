<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/{username}/profile", name="user_profil")
     */
    public function showProfil()
    {
        $user = $this->getUser();

        dump($user);

        return $this->render('user/index.html.twig', [
            'user' => $user
            
        ]);
    }
}
