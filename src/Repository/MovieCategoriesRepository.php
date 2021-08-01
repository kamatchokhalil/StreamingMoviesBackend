<?php

namespace App\Repository;

use App\Entity\MovieCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MovieCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovieCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovieCategories[]    findAll()
 * @method MovieCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovieCategories::class);
    }

    // /**
    //  * @return MovieCategories[] Returns an array of MovieCategories objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MovieCategories
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
