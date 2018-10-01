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
use App\Repository\QuizzRepository;
use App\Service\Slugger;
use App\Repository\CrewQuizzsRepository;

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
    public function showCrew(CrewRepository $cr, $id, UserCrewRepository $ucr, QuizzRepository $qr, $slug, CrewQuizzsRepository $cqr )
    {
        $user = $this->getUser();
        /**
         * TODO service pour vérifier si membre dans le crew et role
         */
        $userCrews = $ucr->findBy(['crew' => $id]);
        $access = false;

        

        if (!$userCrews) {
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
            $privatQuizzs = $qr->findBy(['isPrivate'=>1]);
            $quizzs = $cqr->findBy(['crew'=>$crew]);

            return $this->render('crew/crew.html.twig', [
                'userCrews' => $userCrews,
                'crew' => $crew,
                'user'=>$user,
                'roleUserActif' => $roleUserActif,
                'quizzs'=> $quizzs
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
        $roleUserCrew = $rcrewRepo->findOneBy(['id' => '1']);

        $form = $this->createForm(NewCrewType::class, $crew);
        $form->remove('slug');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (null !== $crew->getAvatar()) {
                $file = $crew->getAvatar();
                $fileName = md5(uniqid()) . "." . $file->guessExtension();
                $file->move($this->getParameter('avatar_directory'), $fileName);
                $crew->setAvatar($fileName);
            }
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
                'id' => $crew->getId(),
                'slug' =>$crew->getSlug(),
            ]);
        }

        return $this->render('crew/newCrew.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/groupe/{id}/edition", name="crew_edit")
     */
    public function editCrew(ObjectManager $manager, $id, Request $request, CrewRepository $cr, UserCrewRepository $ucr)
    {
        $user = $this->getUser();
        $crew = $cr->findOneBy(['id' => $id]);
        $oldAvatar = $crew->getAvatar();

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
        $form = $this->createForm(NewCrewType::class, $crew);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (null === $crew->getAvatar()) {
                $crew->setAvatar($oldAvatar);
            } else {
                $file = $crew->getAvatar();
                $fileName = md5(uniqid()) . "." . $file->guessExtension();
                $file->move($this->getParameter('avatar_directory'), $fileName);
                $crew->setAvatar($fileName);
            }

            //TODO a modifier quand slug OK
            $crew->setSlug('slug');

            $manager->persist($crew);
            $manager->flush();

            return $this->redirectToRoute('crew_show', [
                'id' => $crew->getId(),
                'slug'=>$crew->getSlug(),
            ]);
        }

        return $this->render('crew/editCrew.html.twig', [
            'form' => $form->createView(),
            'crew' => $crew,
        ]);
    }

    /**
     * @route("/groupe/{id}/supprimer", name="crew_delete" )
     */
    public function deleteCrew($id, CrewRepository $crewRepo, UserCrewRepository $ucr)
    {
        $userActive = $this->getUser();
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
            $crew = $crewRepo->findOneById($id);

            $em = $this->getDoctrine()->getManager();
            $em->remove($crew);
            $em->flush();

            return $this->redirectToRoute('crews_show');
        }

        return $this->redirectToRoute('crews_show');
    }

    /**
     * @route("/groupe/{id}/ajouter/{user}/membre", name="crew_add_member")
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
            'slug'=>$crew->getSlug(),
        ]);
    }

    /**
     * @route("/groupe/{id}/role_leader/{user}/membre", name="crew_add_leader")
     */
    public function addLeader(Crewrepository $crewRepo, $user, $id, ObjectManager $manager, UserCrewRepository $ucr, UserRepository $ur, RoleCrewRepository $rcr, Slugger $slug)
    {
        //TODO prevoir un service pour meilleur maintenance
        $userActive = $this->getUser();
        $crew = $crewRepo->findOneById($id);
        //? je recherche le role 2 => leader
        $roleCrew = $rcr->findOneById(2);
        $creater = $rcr->findOneById(1);

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
        
        //? Si l'utilisateur connecté a bien les droit d'ajout j'ajoute le membre.
        if ($access === true) {
            $user = $ur->findOneBy(['userName' => $user, ]);
            $userCrew = $ucr->findOneBy(['crew' => $crew, 'user' => $user, ]);
            
            
            if ($userCrew->getRoleCrew() !== $creater) {
                $userCrew->setRoleCrew($roleCrew);

                $manager->persist($userCrew);
                $manager->flush();

                $this->addFlash('success', ' Pense à féliciter ' . $user->getUserName() . ' pour à promotion ');

                return $this->redirectToRoute('crew_show', [
                    'id' => $crew->getId(),
                    'slug'=>$crew->getSlug(),
                ]);
            }
            $this->addFlash('success', $user->getUserName() . ' est le seul créateur il ne peut pas partir');
    
            return $this->redirectToRoute('crew_show', [
                'id' => $crew->getId(),
                'slug'=>$crew->getSlug(),
            ]);
        }

        $this->addFlash('success', $user->getUserName() . ' est le seul créateur il ne peut pas partir');

        return $this->redirectToRoute('crew_show', [
            'id' => $crew->getId(),
            'slug'=>$crew->getSlug(),
        ]);
    }

    /**
     * @route("/goupe/{id}/role_membre/{user}", name="crew_return_member")
     */
    public function returnMember(Crewrepository $crewRepo, $user, $id, ObjectManager $manager, UserCrewRepository $ucr, UserRepository $ur, RoleCrewRepository $rcr)
    {
        //TODO prevoir un service pour meilleur maintenance
        $userActive = $this->getUser();
        $crew = $crewRepo->findOneById($id);
        //? je recherche le role 2 => leader
        $roleCrew = $rcr->findOneById(3);
        $creater = $rcr->findOneById(1);

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
            if ($userCrew->getRoleCrew() !== $creater) {
                $userCrew->setRoleCrew($roleCrew);

                $manager->persist($userCrew);
                $manager->flush();

                $this->addFlash('success', $user->getUserName() . ' n\'est plus un Dieu ');

                return $this->redirectToRoute('crew_show', [
                    'id' => $crew->getId(),
                    'slug'=>$crew->getSlug(),
                ]);
            }

            $this->addFlash('success', $user->getUserName() . ' est le seul créateur il ne peut pas partir');

            return $this->redirectToRoute('crew_show', [
                'id' => $crew->getId(),
                'slug'=>$crew->getSlug(),
            ]);
        }

        return $this->redirectToRoute('crew_show', [
            'id' => $crew->getId(),
            'slug'=>$crew->getSlug(),
        ]);
    }

    /**
     * @route("/groupe/{id}/role_createur/{user}", name="crew_add_creater")
     */
    public function addcreater(Crewrepository $crewRepo, $user, $id, ObjectManager $manager, UserCrewRepository $ucr, UserRepository $ur, RoleCrewRepository $rcr)
    {
        //TODO prevoir un service pour meilleur maintenance
        $userActive = $this->getUser();
        $crew = $crewRepo->findOneById($id);
        //? je recherche le role 1 => leader
        $creater = $rcr->findOneById(1);
        $leader = $rcr->findOneById(2);

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
            $userCrew->setRoleCrew($creater);

            $manager->persist($userCrew);
            $manager->flush();

            $userActive = $ucr->findOneBy(['crew' => $crew, 'user' => $userActive, ]);
            $userActive->setRoleCrew($leader);
            $manager->persist($userActive);
            $manager->flush();

            $this->addFlash('success', $user->getUserName() . ' est devenu un Dieu ! ');
        }

        return $this->redirectToRoute('crew_show', [
            'id' => $crew->getId(),
            'slug'=>$crew->getSlug(),
        ]);
    }

    /**
     * @route("/groupe/{id}/renvoyer/{user}/membre", name="crew_remove_member")
     */
    public function removeMember(Crewrepository $crewRepo, $user, $id, ObjectManager $manager, UserCrewRepository $ucr, UserRepository $ur, RoleCrewRepository $rcr)
    {
        $userActive = $this->getUser();
        $crew = $crewRepo->findOneById($id);
        $creater = $rcr->findOneById(1);
        $userCrews = $ucr->findBy(['crew' => $id]);
        $access = false;

        //? je boucle sur tous les ensemble crews+user qui ont cette et je verifie si l'utilisateur et bien un membre s'il a le rôle (créateur ou leader) oui access passe a true
        foreach ($userCrews as $userCrew) {
            if ($userCrew->getRoleCrew()->getId() <= 2 || $userCrew->getUser() === $userActive) {
                if ($userCrew->getUser() === $userActive) {
                    $access = true;
                    $crewId = $userCrew->getCrew()->getId();
                }
            }
        }
        /**
         * ? Si l'utilisateur connecté a bien le droit de supprimer le membre et si ce m'embre n'est créateur.
         */
        if ($access === true) {
            $user = $ur->findOneBy(['userName' => $user, ]);
            $userCrew = $ucr->findOneBy(['crew' => $crew, 'user' => $user, ]);
            if ($userActive->getUserName() === $user && $userCrew->getRoleCrew() !== $creater) {
                $manager->remove($userCrew);
                $manager->flush();
                $this->addFlash('success', 'J\'espere que tu as dis au revoir avant de partir ');

                return $this->redirectToRoute('home', [
                    
                ]);
            }

            //? si l'utilisateur n'est pas un créateur
            if ($userCrew->getRoleCrew() !== $creater) {
                $manager->remove($userCrew);
                $manager->flush();
                $this->addFlash('success', ' J\'espere que tu as dit au revoir à  ' . $user->getUserName());

                return $this->redirectToRoute('crew_show', [
                    'id' => $crew->getId(),
                    'slug'=>$crew->getSlug(),
                ]);
            }

            $this->addFlash('success', $user->getUserName() . ' est le seul créateur il ne peut pas partir');

            return $this->redirectToRoute('crew_show', [
                'id' => $crew->getId(),
                'slug'=>$crew->getSlug(),
            ]);
        }

        $this->addFlash('danger', 'Oups ... désolé je me suis perdu peux reéssayer? ');

        return $this->redirectToRoute('crew_show', [
            'id' => $crew->getId(),
            'slug'=>$crew->getSlug(),
        ]);
    }
}
