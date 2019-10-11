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
            ->add('orderBy','v.date ASC, v.time ASC')

        ;
        return $qb->getQuery()->getResult();
    }
}
