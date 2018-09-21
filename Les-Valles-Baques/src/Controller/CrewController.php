<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CrewRepository;

class CrewController extends AbstractController
{
    /**
     * @Route("/crew/{id}", name="crew_show")
     */
    public function index(CrewRepository $ucr, $id)
    {

        $user = $this->getUser();

        $crew = $ucr->findOneBy(['id'=> $id]);
        $access = false;
        foreach ($crew->getMembers() as $member) {
            (($member = $user)? $access = true : '');
        }
        if ($access === true) {

            return $this->render('crew/crewIndex.html.twig', [
                'controller_name' => 'CrewController',
                'crew' => $crew
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    

    }
}
