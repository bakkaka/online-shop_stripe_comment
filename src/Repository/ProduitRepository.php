<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }
    // src/Repository/ProduitRepository.php
public function findAllWithImages()
{
    return $this->createQueryBuilder('p')
        ->leftJoin('p.images', 'i')
        ->addSelect('i')
        ->orderBy('p.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();
}

public function getPaginatorQueryBuilder()
{
    return $this->createQueryBuilder('p')
        ->leftJoin('p.images', 'i')
        ->addSelect('i')
        ->orderBy('p.dateCreation', 'DESC');
}

public function findWithImages(int $id)
{
    return $this->createQueryBuilder('p')
        ->leftJoin('p.images', 'i')
        ->addSelect('i')
        ->where('p.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getOneOrNullResult();
}

    //    /**
    //     * @return Produit[] Returns an array of Produit objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Produit
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
