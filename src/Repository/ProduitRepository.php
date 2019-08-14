<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    const PRIX_MAX = 1000000;
    const PRIX_MIN = 0;
    const KM_MAX = 500000;
    const KM_MIN  = 0;
    const MIN_YEAR = '1960';
    const MAX_YEAR = '2019';

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function findAllToArray()
    {
        return $qb = $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult();
    }

    public function findAllOrderByPrix($order)
    {
        return $qb = $this->createQueryBuilder('p')
            ->orderBy('p.prix', $order)
            ->getQuery()
            ->getResult();
    }

    public function findAllOrderByDateCreation($order)
    {
        return $qb = $this->createQueryBuilder('p')
            ->where('p.isActive = :isActive')
            ->orderBy('p.createdAt', $order)
            ->setParameter('isActive', true)
            ->getQuery()
            ->getResult();
    }

    public function findAllUserAnnoncesOrderByDateCreation($user, $order)
    {
        return $qb = $this->createQueryBuilder('p')
            ->where('p.user = :user')
            ->orderBy('p.createdAt', $order)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;

    }

    public function search($filters, $marque, $modele)
    {
        $orderPrix = null;
        $orderDate = null;
        $prixMin = !empty($filters['PrixMinSlider']) ? $filters['PrixMinSlider'] : self::PRIX_MIN;
        $prixMax = !empty($filters['PrixMaxSlider']) ? $filters['PrixMaxSlider'] : self::PRIX_MAX;
        $kmMin = !empty($filters['kmMin']) ? $filters['kmMin'] : self::KM_MIN;
        $kmMax = !empty($filters['kmMax']) ? $filters['kmMax'] : self::KM_MAX;
        $yearMin = !empty($filters['minYear']) ? $filters['minYear'] : self::MIN_YEAR;
        $yearMax = !empty($filters['maxYear']) ? $filters['maxYear'] : self::MAX_YEAR;
        $yearMin = $yearMin.'-01-01';
        $yearMax = $yearMax.'-12-31';
        $marqueid = !empty($marque) ? $marque : null;
        $modeleid = !empty($modele) ? $modele : null;
        $location = !empty($filters['location']) ? $filters['location'] : null;

        switch ($filters['sort']) {
            case 'ASC_prix':
                $orderPrix = 'ASC';
            break;
            case 'DESC_prix':
                $orderPrix = 'DESC';
            break;
            case 'ASC_pub':
                $orderDate = 'ASC';
            break;
            case 'DESC_pub':
                $orderDate = 'DESC';
            break;
        }

        $qb = $this
            ->createQueryBuilder('p')
            ->join('p.voiture', 'v')
            ->join('p.marque', 'ma')
            ->join('p.modele', 'mo')
            ->where('v.kilometrage BETWEEN :min AND :max')
            ->andWhere('p.prix BETWEEN :pmin AND :pmax')
            ->andWhere('v.dateMiseCirculation BETWEEN :ymin AND :ymax')
            ->andWhere('p.isActive = :isActive')
            ->andWhere('p.localisation LIKE :localisation')
            ->setParameter('pmin', $prixMin)
            ->setParameter('pmax', $prixMax)
            ->setParameter('min', $kmMin)
            ->setParameter('max', $kmMax)
            ->setParameter('ymin', $yearMin)
            ->setParameter('ymax', $yearMax)
            ->setParameter('isActive', true)
            ->setParameter('localisation', '%'.$location.'%')
        ;

        if($marqueid !== null) {
            $qb
                ->andWhere('ma.id =:marqueid')
                ->setParameter('marqueid', $marqueid)
            ;
        }

        if($modeleid !== null) {
            $qb
                ->andWhere('mo.id =:modeleid')
                ->setParameter('modeleid', $modeleid)
            ;
        }

//        Sort by prix
        if(!empty($orderPrix)) {
            $qb
                ->orderBy('p.prix', $orderPrix)
            ;
//        Sort by created date
        } elseif (!empty($orderDate)) {
            $qb
                ->orderBy('p.createdAt', $orderDate)
            ;
        }

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function findLastProducts($max)
    {
        return $qb = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($max)
            ->getQuery()
            ->getResult()
            ;
    }
}
