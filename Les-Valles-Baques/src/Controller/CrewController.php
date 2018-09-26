<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CrewRepository;
use App\Repository\UserCrewRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Crew;
use App\Form\NewCrewType;
use App\Entity\UserCrew;
use App\Repository\RoleCrewRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\DataCollector\DumpDataCollector;

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
        } else {
            return $this->redirectToRoute('home');
        }

    }
    
    /**
     * @Route("/groupe/creation", name="crew_creat")
     * 
     */
    public function newCrew(ObjectManager $manager, Request $request, RoleCrewRepository $rcrewRepo)
    {
        $user = $this->getUser();
        $crew = new Crew();
        $userCrew = new UserCrew;
        $roleUserCrew = $rcrewRepo->findOneBy(['id'=>'1']);

        $form = $this->createForm(NewCrewType::class, $crew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //TODO a modifier quand slug OK
            $crew->setSlug('slug');
            $manager->persist($crew);
            $manager->flush();

            $userCrew->setUser($user);
            $userCrew->setCrew($crew);
            $userCrew->setRoleCrew($roleUserCrew);
            $manager->persist($userCrew);
            $manager->flush();

            return $this->redirectToRoute('crew_show',[
                'id'=> $user->getId(),
            ]);
        }

        return $this->render('crew/newCrew.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
    * @route('/crew/{id}/supprimer', name='crew_delete' ) 
    */
    public function deleteCrew($id, $crew, CrewRepository $crewRepo, EntityManager $em)
    {
        $crewRepo->findById($id);
        dump($crewRepo);
    }
     
}
