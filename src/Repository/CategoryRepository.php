<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findAllByCategory($category)
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->leftJoin('c.films', 'f')
            ->leftJoin('c.serials', 's')
            ->where('f.categories = :categories')
            ->setParameter('categories', $category)
            ->getQuery()
            ->getResult();
    }

    public function findAllSerialsAndFilms()
    {
        return $this->createQueryBuilder('c')
            ->select('serial','film')
            ->from('App:Serial','serial' )
            ->from('App:Film','film' )
            ->getQuery()
            ->getResult();
    }
}
