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


    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function findAllSerialsAndFilms()
    {


       $queryFilm= $this->_em->createQueryBuilder()
        ->select('count(f) as count')
        ->from('App\Entity\Film', 'f')
        ->getQuery();
       $querySerial= $this->_em->createQueryBuilder()
            ->select('count(s) as count')
            ->from('App\Entity\Serial', 's')
            ->getQuery();

       if($queryFilm->getSingleScalarResult() > "0" && $querySerial->getSingleScalarResult() > "0"){

           return $this->_em->createQueryBuilder()
               ->select('f','s')
               ->from('App\Entity\Film', 'f')
               ->from('App\Entity\Serial', 's')
               ->getQuery()
               ->getResult();
       }
        elseif ($queryFilm->getSingleScalarResult() === "0" ){

            return $this->_em->createQueryBuilder()
                ->select('s')
                ->from('App\Entity\Serial', 's')
                ->getQuery()
                ->getResult();
        }
       elseif($querySerial->getSingleScalarResult() === "0" ){

           return $this->_em->createQueryBuilder()
               ->select('f')
               ->from('App\Entity\Film', 'f')
               ->getQuery()
               ->getResult();
       }


    }

}
