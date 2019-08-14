<?php

namespace App\Repository;

use App\Entity\Searchyearmin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Searchyearmin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Searchyearmin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Searchyearmin[]    findAll()
 * @method Searchyearmin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchyearminRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Searchyearmin::class);
    }

    // /**
    //  * @return Searchyearmin[] Returns an array of Searchyearmin objects
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
    public function findOneBySomeField($value): ?Searchyearmin
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
