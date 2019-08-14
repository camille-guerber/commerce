<?php

namespace App\Repository;

use App\Entity\Searchprixmax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Searchprixmax|null find($id, $lockMode = null, $lockVersion = null)
 * @method Searchprixmax|null findOneBy(array $criteria, array $orderBy = null)
 * @method Searchprixmax[]    findAll()
 * @method Searchprixmax[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchprixmaxRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Searchprixmax::class);
    }

    // /**
    //  * @return Searchprixmax[] Returns an array of Searchprixmax objects
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
    public function findOneBySomeField($value): ?Searchprixmax
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
