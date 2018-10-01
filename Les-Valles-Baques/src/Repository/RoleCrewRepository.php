<?php

namespace App\Repository;

use App\Entity\RoleCrew;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RoleCrew|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoleCrew|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoleCrew[]    findAll()
 * @method RoleCrew[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleCrewRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RoleCrew::class);
    }

//    /**
//     * @return RoleCrew[] Returns an array of RoleCrew objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RoleCrew
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
