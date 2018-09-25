<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\IsLikeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\QuizzRepository;
use App\Entity\IsLike;

class IsLikeController extends AbstractController
{
    /**
     * TODO replacer id par slug
     * @Route ("quizz/like_{id}", name = "add_like")
     */
    public function addLike($id, IsLikeRepository $likeRepo, ObjectManager $manager, QuizzRepository $quizzRepo)
    {
        $user = $this->getUser();

        $quizz = $quizzRepo->findOneBy(['id' => $id]);
        
        /*$em = $this->getDoctrine()->getManager(); // ...or getEntityManager() prior to Symfony 2.1
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT COUNT(*) FROM is_like WHERE like_it='1' AND quizz_id= :id");
        $statement->bindValue('id', $id);
        $statement->execute();
        $aa = $statement->fetchAll();
        dump($aa);
        exit;*/
        dump($likeRepo->countLikeByQuizz($id));
       


        //dcountLikeByQuizz($value);

        $Like = $likeRepo->findOneBy(['quizz' => $id, 'user' => $user->getId()]);
        if ($Like === null) {
            $toogle = 1;
            $Like = new IsLike;
            $Like->setUser($user);
            $Like->setQuizz($quizz);
            $Like->setLikeIt($toogle);
        } else {
            ((true === $Like->getLikeIt()) ? $Like->setLikeIt(false) : $Like->setLikeIt(true));
        }
        $manager->persist($Like);
        dump($Like->getLikeIt());
        $manager->flush();

        return $this->redirectToRoute('quizz_list_sort', [
            'sort' => 'title'

        ]);
    }
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
