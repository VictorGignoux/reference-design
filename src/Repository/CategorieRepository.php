<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    public function findFirstCategory(): ?Categorie
    {
        return $this->createQueryBuilder('i')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findPrimaryCategories() : array
    {
        return $this->createQueryBuilder('i')
            ->where('i.depend IS NULL')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPrimaryCategoriesForm()
    {
        return $this->createQueryBuilder('i')
            ->where('i.depend IS NULL');
    }

    public function findSecondaryCategories() : array
    {
        return $this->createQueryBuilder('i')
            ->where('i.depend IS NOT NULL')
            ->getQuery()
            ->getResult();
    }

    public function findSecondaryCategoriesForm()
    {
        return $this->createQueryBuilder('i')
            ->where('i.depend IS NOT NULL');
    }

    public function findByPrimaryCategorie(string $idCategorie) : array 
    {
        return $this->createQueryBuilder('i')
            ->where('i.depend = :idCategorie')
            ->setParameter('idCategorie', $idCategorie)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAvailableCategories(string $mode, string $art)
    {
        return $this->createQueryBuilder('i')
            ->where('i.nom != :mode')
            ->andwhere('i.nom != :art')
            ->setParameter('mode', $mode)
            ->setParameter('art', $art)
        ;
    }

//    /**
//     * @return Categorie[] Returns an array of Categorie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Categorie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
