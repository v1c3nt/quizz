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
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CrewQuizzs
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
