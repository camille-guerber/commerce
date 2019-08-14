<?php

namespace App\Repository;

use App\Entity\Searchprixmin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Searchprixmin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Searchprixmin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Searchprixmin[]    findAll()
 * @method Searchprixmin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchprixminRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Searchprixmin::class);
    }

    // /**
    //  * @return Searchprixmin[] Returns an array of Searchprixmin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Searchprixmin
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
