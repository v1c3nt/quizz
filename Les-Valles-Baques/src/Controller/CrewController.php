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
use Doctrine\ORM\UserManager;
use App\Repository\UserRepository;

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
        /**
         * TODO service pour vérifier si membre dans le crew et role
         */
        $userCrews = $ucr->findBy(['crew' => $id]);
        $access = false;

        //? je boucle sur tous les ensemble crews+user qui ont cette et je verifie si l'utilisateur et bien un membre si oui access passe a true
        foreach ($userCrews as $userCrew) {
            if ($userCrew->getUser() === $user) {
                $access = true;
            };
        }

        if ($access === true) {
            $crew = $cr->findOneBy(['id' => $id]);

            return $this->render('crew/crew.html.twig', [
                'userCrews' => $userCrews,
                'crew' => $crew,
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
        $roleUserCrew = $rcrewRepo->findOneBy(['id' => '1']);

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

            return $this->redirectToRoute('crew_show', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('crew/newCrew.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/groupe/{id}/edition", name="crew_edit")
     * 
     */
    public function editCrew(ObjectManager $manager, $id, Request $request, CrewRepository $cr, UserCrewRepository $ucr )
    {
       
        $user = $this->getUser();
        $crew = $cr->findOneBy(['id'=> $id]);
        $usercrew = 

        //TODO prevoir un service pour meilleur maintenance
        $userActive = $this->getUser();
        $crew = $cr->findOneById($id);
        //? je recherche le role 1 => leader

        $userCrews = $ucr->findBy(['crew' => $id]);
        $access = false;

        //? je boucle sur tous les ensemble crews+user qui ont cette et je verifie si l'utilisateur et bien un membre s'il a le rôle créateur oui access passe a true
        foreach ($userCrews as $userCrew) {
            if ($userCrew->getRoleCrew()->getId() <= 1) {
                if ($userCrew->getUser() === $userActive) {
                    $access = true;
                    $crewId = $userCrew->getCrew()->getId();
                }
            }
        }
        dump([$access, $crew]);
        
        $form = $this->createForm(NewCrewType::class, $crew);
        $form->remove('avatarFile');
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
    
    //TODO a modifier quand slug OK
    dump($crew);
    exit;
            $crew->setSlug('slug');
            $manager->persist($crew);
            $manager->flush();

            $userCrew->setUser($user);
            $userCrew->setCrew($crew);
            $userCrew->setRoleCrew($roleUserCrew);
            $manager->persist($userCrew);
            $manager->flush();


            return $this->redirectToRoute('crew_show', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('crew/editCrew.html.twig', [
            'form' => $form->createView(),
            'crew' => $crew,
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

    /**
     * @route("/crew/{id}/add/{user}/membre", name="crew_add_member")
     */
    public function addMember(Crewrepository $crewRepo, $user, $id, ObjectManager $manager, UserCrewRepository $ucr, UserRepository $ur, RoleCrewRepository $rcr)
    {
        $userActive = $this->getUser();
        $crew = $crewRepo->findOneById($id);
        $roleCrew = $rcr->findOneById(3);

        $userCrews = $ucr->findBy(['crew' => $id]);
        $access = false;

        //? je boucle sur tous les ensemble crews+user qui ont cette et je verifie si l'utilisateur et bien un membre s'il a le rôle (créateur ou leader) oui access passe a true
        foreach ($userCrews as $userCrew) {
            if ($userCrew->getRoleCrew()->getId() <= 2) {
                if ($userCrew->getUser() === $userActive) {
                    $access = true;
                    $crewId = $userCrew->getCrew()->getId();
                }
            }
        }
        /**
         * ? Si l'utilisateur connecté a bien les droit d'ajout j'ajoute le membre.
         */
        if ($access === true) {

            $user = $ur->findOneBy(['userName' => $user, ]);
            $userCrew = new UserCrew;
            $userCrew->setCrew($crew);
            $userCrew->setuser($user);
            $userCrew->setRoleCrew($roleCrew);

            $manager->persist($userCrew);
            $manager->flush();

            $this->addFlash('success', ' Pense à souhaiter la bienvenue à ' . $user->getUserName());

        }

        return $this->redirectToRoute('crew_show', [
            'id' => $crew->getId(),
        ]);
    }

    /**
     * @route("/crew/{id}/promt/{user}/membre", name="crew_add_leader")
     */
    public function addLeader(Crewrepository $crewRepo, $user, $id, ObjectManager $manager, UserCrewRepository $ucr, UserRepository $ur, RoleCrewRepository $rcr)
    {
        //TODO prevoir un service pour meilleur maintenance
        $userActive = $this->getUser();
        $crew = $crewRepo->findOneById($id);
        //? je recherche le role 2 => leader
        $roleCrew = $rcr->findOneById(2);

        $userCrews = $ucr->findBy(['crew' => $id]);
        $access = false;

        //? je boucle sur tous les ensemble crews+user qui ont cette et je verifie si l'utilisateur et bien un membre s'il a le rôle créateur oui access passe a true
        foreach ($userCrews as $userCrew) {
            if ($userCrew->getRoleCrew()->getId() <= 1) {
                if ($userCrew->getUser() === $userActive) {
                    $access = true;
                    $crewId = $userCrew->getCrew()->getId();
                }
            }
        }
        /**
         * ? Si l'utilisateur connecté a bien les droit d'ajout j'ajoute le membre.
         */
        if ($access === true) {

            $user = $ur->findOneBy(['userName' => $user, ]);
            $userCrew = $ucr->findOneBy(['crew' => $crew, 'user' => $user, ]);
            $userCrew->setRoleCrew($roleCrew);

            $manager->persist($userCrew);
            $manager->flush();

            $this->addFlash('success', ' Pense à féliciter ' . $user->getUserName() . ' pour à promotion ');

        }

        return $this->redirectToRoute('crew_show', [
            'id' => $crew->getId(),
        ]);
    }

    /**
     * @route("/crew/{id}/retunr/{user}/membre", name="crew_return_member")
     */
    public function returnMemeber(Crewrepository $crewRepo, $user, $id, ObjectManager $manager, UserCrewRepository $ucr, UserRepository $ur, RoleCrewRepository $rcr)
    {
        dump('ici');
        //TODO prevoir un service pour meilleur maintenance
        $userActive = $this->getUser();
        $crew = $crewRepo->findOneById($id);
        //? je recherche le role 2 => leader
        $roleCrew = $rcr->findOneById(3);

        $userCrews = $ucr->findBy(['crew' => $id]);
        $access = false;

        //? je boucle sur tous les ensemble crews+user qui ont cette et je verifie si l'utilisateur et bien un membre s'il a le rôle créateur oui access passe a true
        foreach ($userCrews as $userCrew) {
            if ($userCrew->getRoleCrew()->getId() <= 1) {
                if ($userCrew->getUser() === $userActive) {
                    $access = true;
                    $crewId = $userCrew->getCrew()->getId();
                }
            }
        }
        /**
         * ? Si l'utilisateur connecté a bien les droit d'ajout j'ajoute le membre.
         */
        if ($access === true) {

            $user = $ur->findOneBy(['userName' => $user, ]);
            $userCrew = $ucr->findOneBy(['crew' => $crew, 'user' => $user, ]);
            $userCrew->setRoleCrew($roleCrew);

            $manager->persist($userCrew);
            $manager->flush();

            $this->addFlash('success', ' Pense à féliciter ' . $user->getUserName() . ' pour à promotion ');

        }

        return $this->redirectToRoute('crew_show', [
            'id' => $crew->getId(),
        ]);
    }

    /**
     * @route("/crew/{id}/upgade/{user}/membre", name="crew_add_creater")
     */
    public function addcreater(Crewrepository $crewRepo, $user, $id, ObjectManager $manager, UserCrewRepository $ucr, UserRepository $ur, RoleCrewRepository $rcr)
    {
       //TODO prevoir un service pour meilleur maintenance
        $userActive = $this->getUser();
        $crew = $crewRepo->findOneById($id);
        //? je recherche le role 1 => leader
        $roleCrew = $rcr->findOneById(1);

        $userCrews = $ucr->findBy(['crew' => $id]);
        $access = false;

        //? je boucle sur tous les ensemble crews+user qui ont cette et je verifie si l'utilisateur et bien un membre s'il a le rôle créateur oui access passe a true
        foreach ($userCrews as $userCrew) {
            if ($userCrew->getRoleCrew()->getId() <= 1) {
                if ($userCrew->getUser() === $userActive) {
                    $access = true;
                    $crewId = $userCrew->getCrew()->getId();
                }
            }
        }
        /**
         * ? Si l'utilisateur connecté a bien les droit d'ajout j'ajoute le membre.
         */
        if ($access === true) {

            $user = $ur->findOneBy(['userName' => $user, ]);
            $userCrew = $ucr->findOneBy(['crew' => $crew, 'user' => $user, ]);
            $userCrew->setRoleCrew($roleCrew);

            $manager->persist($userCrew);
            $manager->flush();

            $this->addFlash('success', $user->getUserName() . ' est devenu un Dieu ! ');

        }

        return $this->redirectToRoute('crew_show', [
            'id' => $crew->getId(),
        ]);
    }

    /**
     * @route("/crew/{id}/renvoyer/{user}/membre", name="crew_remove_member")
     */
    public function removeMember(Crewrepository $crewRepo, $user, $id, ObjectManager $manager, UserCrewRepository $ucr, UserRepository $ur, RoleCrewRepository $rcr)
    {
        $userActive = $this->getUser();
        $crew = $crewRepo->findOneById($id);
        $roleCrew = $rcr->findOneById(3);
        $roleCreater = $rcr->findOneById(1);

        $userCrews = $ucr->findBy(['crew' => $id]);
        $access = false;
        dump([$userActive, $id, $roleCrew]);
        //? je boucle sur tous les ensemble crews+user qui ont cette et je verifie si l'utilisateur et bien un membre s'il a le rôle (créateur ou leader) oui access passe a true
        foreach ($userCrews as $userCrew) {

            if ($userCrew->getRoleCrew()->getId() <= 2) {
                if ($userCrew->getUser() === $userActive) {
                    $access = true;
                    $crewId = $userCrew->getCrew()->getId();
                }
            }
        }
        /**
         * ? Si l'utilisateur connecté a bien les droit d'ajout j'ajoute le membre.
         */
        if ($access === true) {



            $user = $ur->findOneBy(['userName' => $user, ]);
            $userCrew = $ucr->findOneBy(['crew' => $crew, 'user' => $user, ]);

            if ($userCrew->getRoleCrew() !== $roleCreater) {

                $manager->remove($userCrew);
                $manager->flush();
                $this->addFlash('success', ' J\'espere que tu as dit au revoir à  ' . $user->getUserName());

                return $this->redirectToRoute('crew_show', [
                    'id' => $crew->getId(),
                ]);
            }

        }

        $this->addFlash('danger', $user->getUserName() . ' est un Dieu, tu ne peux pas faire ça');

        return $this->redirectToRoute('crew_show', [
            'id' => $crew->getId(),
        ]);


    }

}
