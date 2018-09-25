<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IsLikeController extends AbstractController
{
    /**
     * @Route("/is/like", name="is_like")
     */
    public function index()
    {
        return $this->render('is_like/index.html.twig', [
            'controller_name' => 'IsLikeController',
        ]);
    }
}
