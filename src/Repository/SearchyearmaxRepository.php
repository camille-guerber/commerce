<?php

namespace App\Repository;

use App\Entity\Searchyearmax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Searchyearmax|null find($id, $lockMode = null, $lockVersion = null)
 * @method Searchyearmax|null findOneBy(array $criteria, array $orderBy = null)
 * @method Searchyearmax[]    findAll()
 * @method Searchyearmax[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchyearmaxRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Searchyearmax::class);
    }

    // /**
    //  * @return Searchyearmax[] Returns an array of Searchyearmax objects
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
    public function findOneBySomeField($value): ?Searchyearmax
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
