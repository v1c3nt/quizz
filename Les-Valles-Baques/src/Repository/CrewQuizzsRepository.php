<?php

namespace App\Repository;

use App\Entity\CrewQuizzs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CrewQuizzs|null find($id, $lockMode = null, $lockVersion = null)
 * @method CrewQuizzs|null findOneBy(array $criteria, array $orderBy = null)
 * @method CrewQuizzs[]    findAll()
 * @method CrewQuizzs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CrewQuizzsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CrewQuizzs::class);
    }

//    /**
//     * @return CrewQuizzs[] Returns an array of CrewQuizzs objects
//     */
 
    public function findByCrew($crew)
    {
        return $this->createQueryBuilder('c')
        //? quizz private 
        ->innerJoin('c.Quizz', 'q')
            ->andWhere('c.crew = :val')
            ->andWhere('q.isPrivate = true')
            ->setParameter('val', $crew)
            ->orderBy('q.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
 
}
