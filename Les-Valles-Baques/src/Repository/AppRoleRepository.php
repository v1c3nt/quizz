<?php

namespace App\Repository;

use App\Entity\AppRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AppRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppRole[]    findAll()
 * @method AppRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppRoleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AppRole::class);
    }

//    /**
//     * @return AppRole[] Returns an array of AppRole objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AppRole
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
