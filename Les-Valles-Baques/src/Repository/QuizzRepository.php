<?php

namespace App\Repository;

use App\Entity\Quizz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Quizz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quizz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quizz[]    findAll()
 * @method Quizz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizzRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Quizz::class);
    }

    public function findByCategory()
    {
        return $this->createQueryBuilder('q')
            ->innerJoin('q.category', 'c')
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findPublicCompleted()
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.isPrivate = false')
            ->andWhere('q.completedAt is not NULL')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findFourPublicCompleted()
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.isPrivate = false')
            ->andWhere('q.completedAt is not NULL')
            ->orderBy('q.id' , 'DESC')
            ->getQuery()
            ->setMaxResults(4)
            ->getResult()
        ;
    }

    public function findRandomPublicCompleted()
    {
        $quizzes = $this->findPublicCompleted();

        $new = count($quizzes);
        $randomKey = $quizzes[array_rand($quizzes)]->getId();

        return $this->createQueryBuilder('q')
            ->andWhere('q.isPrivate = false')
            ->andWhere('q.completedAt is not NULL')
            ->where('q.id = :ids')
            ->setParameter('ids', $randomKey)
            ->getQuery()
            ->setMaxResults(1)->getOneOrNullResult()
        ;
    }

    
    public function findInProgress($value)
    {
        $id = $value->getId();

        return $this->createQueryBuilder('q')
            ->andWhere('q.completedAt is NULL')
            ->andWhere('q.author = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult()
        ;
    }

}
