<?php

namespace App\Repository;

use App\Entity\Voyage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Voyage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voyage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voyage[]    findAll()
 * @method Voyage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoyageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Voyage::class);
    }

    // /**
    //  * @return Voyage[] Returns an array of Voyage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Voyage
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllNotReserved() {
        return $this->createQueryBuilder('v')
            ->andWhere('v.reservation is null')
            ->orderBy('v.destinationCountry')
            ->getQuery()
            ->getResult();
    }

    public function findLastTwelveNotReserved() {
        return $this->createQueryBuilder('v')
            ->andWhere('v.reservation is null')
            ->orderBy('v.id', 'desc')
            ->setMaxResults(12)
            ->getQuery()
            ->getResult();
    }

    public function getNotReservedBuilder() {
        return $this->createQueryBuilder('v')
            ->andWhere('v.reservation is null');
    }

    public function getAlldBuilder() {
        return $this->createQueryBuilder('v');
    }

    public function getImageById(int $id) {
        return $this->createQueryBuilder('v')
            ->select('v.image')
            ->andWhere('v.id = :id')
            ->setParameter(":id", $id)
            ->getQuery()
            ->getResult();
    }
}
