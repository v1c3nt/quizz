<?php

namespace App\Repository;

use App\Entity\IsLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IsLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method IsLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method IsLike[]    findAll()
 * @method IsLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IsLikeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IsLike::class);
    }

    public function countLikeByQuizz($id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT COUNT(*) FROM is_like WHERE like_it='1' AND quizz_id= :id";
        $stmt = $conn->prepare($sql);
        
        $stmt->execute(['id'=>$id]);
        return $stmt->fetchAll();
    }


//    /**
//     * @return IsLike[] Returns an array of IsLike objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
