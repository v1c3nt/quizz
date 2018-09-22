<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CrewRepository;
use App\Repository\UserCrewRepository;

class CrewController extends AbstractController
{
    /**
     * @Route("/mes_groupes", name="crews_show")
     */
    public function crewList(CrewRepository $cr, UserCrewRepository $ucr)
    {

        $user = $this->getUser();
        $userCrews = $ucr->findBy(['user' => $user]);
        $crews = $cr->findAll();
        $access = false;

        foreach ($crews as $crew) {

            foreach ($crew->getMembers() as $member) {

                if ($member->getUser() === $user) {
                    $myCrew[] = $crew;
                    $access = true;
                };
            }
        }
        if ($access === true) {

            return $this->render('crew/crews.html.twig', [
                'controller_name' => 'CrewController',
                'usercrews' => $userCrews,
                'mycrew' => $myCrew
            ]);
        } else {
            return $this->redirectToRoute('home');
        }

    }

    /**
     * @Route("/groupe_{id}", name="crew_show")
     */
    public function showCrew(CrewRepository $cr, $id, UserCrewRepository $ucr) 
    {
        $user = $this->getUser();
        $userCrews = $ucr->findBy(['crew' => $id]);
        $access = false;

        //? je boucle sur tous les crews et je verifie si l'utilisateur et bien un membre si oui access passe a true
        foreach ($userCrews as $userCrew) {
                if ($userCrew->getUser() === $user) {
                    $access = true;
                };
        }

        if ($access === true) {

        return $this->render('crew/crew.html.twig', [
            'userCrews' => $userCrews,
        ]);
    }else{
            return $this->redirectToRoute('home');
    }


}

}
