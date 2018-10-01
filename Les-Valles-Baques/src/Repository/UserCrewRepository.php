<?php

namespace App\Repository;

use App\Entity\UserCrew;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserCrew|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCrew|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCrew[]    findAll()
 * @method UserCrew[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCrewRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserCrew::class);
    }

//    /**
//     * @return UserCrew[] Returns an array of UserCrew objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserCrew
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
