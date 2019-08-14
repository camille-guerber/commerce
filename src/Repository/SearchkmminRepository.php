<?php

namespace App\Repository;

use App\Entity\Searchkmmin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Searchkmmin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Searchkmmin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Searchkmmin[]    findAll()
 * @method Searchkmmin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchkmminRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Searchkmmin::class);
    }

    // /**
    //  * @return Searchkmmin[] Returns an array of Searchkmmin objects
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
    public function findOneBySomeField($value): ?Searchkmmin
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
