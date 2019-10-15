<?php

namespace App\Repository;

use App\Entity\Garage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\YamlFileLoader;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * @method Garage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Garage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Garage[]    findAll()
 * @method Garage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GarageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Garage::class);
    }

    public function getGarages($lat, $lng)
    {
        $em = $this->getEntityManager();

        $sql = "SELECT *, 6371 * 2 * 
        ASIN(SQRT( POWER(SIN(($lat - lat)*pi()/180/2),2)
        +COS($lat*pi()/180 )*COS(lng*pi()/180)
        *POWER(SIN(($lng-lng)*pi()/180/2),2))) 
        as distance FROM garage WHERE 
        lng between ($lng-50/cos(radians($lat))*69) 
        and ($lng+50/cos(radians($lat))*69) 
        and lat between ($lat-(50/69)) 
        and ($lat+(50/69)) 
        having distance < 50 ORDER BY distance";

        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addEntityResult(Garage::class, "g");

        // On mappe le nom de chaque colonne en base de données sur les attributs de nos entités
        foreach ($this->getClassMetadata()->fieldMappings as $obj) {
            $rsm->addFieldResult("g", $obj["columnName"], $obj["fieldName"]);
        }
    
        $stmt = $this->getEntityManager()->createNativeQuery($sql, $rsm);
    
        $stmt->execute();
    
        return $stmt->getResult();
 
    }

    // /**
    //  * @return Garage[] Returns an array of Garage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Garage
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
}
