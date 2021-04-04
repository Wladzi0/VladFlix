<?php

namespace App\Repository;

use App\Entity\Serial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Serial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serial[]    findAll()
 * @method Serial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serial::class);
    }

    public function findAllByCategory($category)
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.categories', 'c')
            ->where('c.id = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    public function findSerialBySeason($seasonId)
    {
        return $this->createQueryBuilder('serial')
            ->leftJoin('serial.season', 'season')
            ->where('season.id =:season')
            ->setParameter('season', $seasonId)
            ->getQuery()
            ->getSingleResult();
    }
}
