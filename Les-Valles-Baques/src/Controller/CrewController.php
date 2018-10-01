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
use App\Service\Slugger;

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
     * @Route("/groupe_{id}/{slug}", name="crew_show")
     */
    public function showCrew(CrewRepository $cr, $id, UserCrewRepository $ucr, $slug)
    {
        $user = $this->getUser();

        /**
         * TODO service pour vérifier si membre dans le crew et role
         */
        $userCrews = $ucr->findBy(['crew' => $id]);
        $access = false;

        if (!$iserCrews) {
            throw $this->createNotFoundException('Il n\'y a rien par ici.');
        }

        
        //? je boucle sur tous les ensemble crews+user qui ont cette et je verifie si l'utilisateur et bien un membre si oui access passe a true
        foreach ($userCrews as $userCrew) {
            if ($userCrew->getUser() === $user) {
                $access = true;
                $roleUserActif = $userCrew->getRoleCrew()->getId();
            };
        }
        if ($access === true) {
            $crew = $cr->findOneBy(['id' => $id]);
            return $this->render('crew/crew.html.twig', [
                'userCrews' => $userCrews,
                'crew' => $crew,
                'user'=>$user,
                'roleUserActif' => $roleUserActif
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }
    
    /**
     * @Route("/groupe/creation", name="crew_creat")
     *
     */
    public function newCrew(ObjectManager $manager, Request $request, RoleCrewRepository $rcrewRepo, Slugger $slugger)
    {
        $user = $this->getUser();
        $crew = new Crew();
        $userCrew = new UserCrew;
        $roleUserCrew = $rcrewRepo->findOneBy(['id'=>'1']);

        $form = $this->createForm(NewCrewType::class, $crew);
        $form->remove('slug');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
    //TODO a modifier quand slug OK
            //$crew->setSlug('slug');
            $manager->persist($crew);
            $manager->flush();

            $userCrew->setUser($user);
            $userCrew->setCrew($crew);
            $userCrew->setRoleCrew($roleUserCrew);
            $convertedName = $slugger->slugify($crew->getName());
            $crew->setSlug($convertedName);

            $manager->persist($userCrew);
            $manager->flush();

            return $this->redirectToRoute('crew_show', [
                'id'=> $user->getId(),
                'slug' =>$crew->getSlug(),
            ]);
        }

        return $this->render('crew/newCrew.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @route("/crew/{id}/supprimer", name="crew_delete" )
    */
    public function deleteCrew($id, CrewRepository $crewRepo)
    {
        $crew = $crewRepo->findOneById($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($crew);
        $em->flush();
         
        return $this->redirectToRoute('crews_show');
    }
}
