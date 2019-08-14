<?php

namespace App\Repository;

use App\Entity\Searchkmmax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Searchkmmax|null find($id, $lockMode = null, $lockVersion = null)
 * @method Searchkmmax|null findOneBy(array $criteria, array $orderBy = null)
 * @method Searchkmmax[]    findAll()
 * @method Searchkmmax[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchkmmaxRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Searchkmmax::class);
    }

    // /**
    //  * @return Searchkmmax[] Returns an array of Searchkmmax objects
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
    public function findOneBySomeField($value): ?Searchkmmax
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
