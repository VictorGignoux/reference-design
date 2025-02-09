<?php

namespace App\Repository;

use App\Entity\Reference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reference>
 */
class ReferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reference::class);
    }

    public function findByCategorie(int $idCategorie) : array 
    {
        return $this->createQueryBuilder('i')
            ->where('i.categorie = :idCategorie')
            ->setParameter('idCategorie', $idCategorie)
            ->orderBy('i.id','DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByPrimaryCategorie(int $idCategorie) : array 
    {
        return $this->createQueryBuilder('i')
            ->leftjoin('i.categorie', 'c')
            ->where('c.depend = :idCategorie')
            ->setParameter('idCategorie', $idCategorie)
            ->orderBy('i.id','DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findNextReference(int $currentId, int $categorieId): ?Reference
    {
        return $this->createQueryBuilder('i')
            ->where('i.id > :currentId')
            ->andwhere('i.categorie = :categorieId')
            ->setParameter('currentId', $currentId)
            ->setParameter('categorieId', $categorieId)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findPreviousReference(int $currentId, int $categorieId): ?Reference
    {
        return $this->createQueryBuilder('i')
            ->where('i.categorie = :categorieId')  // Filtrer par la catégorie
            ->andWhere('i.id < :currentId')  // Ajouter la condition pour l'ID suivant
            ->setParameter('categorieId', $categorieId)
            ->setParameter('currentId', $currentId)
            ->orderBy('i.id', 'DESC')  // Trier par ID de manière décroissante pour obtenir le plus proche précédent
            ->setMaxResults(1)  // Limiter à un seul résultat
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return Reference[] Returns an array of Reference objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reference
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
