<?php

namespace App\Repository;

use App\Entity\Visit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Visit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visit[]    findAll()
 * @method Visit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visit::class);
    }

     /**
      * @param Garage $garage
      * @return Visit[]
      */
    
    public function findByDate($garage)
    {
        $qb = $this->createQueryBuilder('v')
            ->where('v.garage = :myGarage')
            ->setParameter('myGarage', $garage)
            // ->select('v.date', 'v.time', 'v.id')
            // ->groupBy('v.date')
            // ->orderBy('v.date', 'ASC', 'v.time')
            ->add('orderBy','v.date ASC, v.time ASC')

        ;
        return $qb->getQuery()->getResult();
    }

        /**
     * S02E09 - EXO 2
     * Récupérer les castings d'un movie donné + les infos de Person
     * Méthode DQL
     * 
     * @param garage $movie
     * @return Visit[]
     */
    public function findByDateDQL($garage)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT v 
            FROM App\Entity\Visit v
            WHERE v.garage = :garage
            GROUP BY v.date
        ')
        ->setParameter('garage', $garage);
        return $query->getResult(); 
    }
    /*
    public function findOneBySomeField($value): ?Visit
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
