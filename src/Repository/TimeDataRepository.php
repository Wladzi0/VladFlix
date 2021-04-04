<?php

namespace App\Repository;

use App\Entity\TimeData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TimeData|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimeData|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimeData[]    findAll()
 * @method TimeData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeData::class);
    }

    public function findByFileAndProfile($fileId, $profileId)
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.file', 'file')
            ->leftJoin('t.profile', 'profile')
            ->where('file.id = :file')
            ->andWhere('profile.id = :profile')
            ->setParameter('file', $fileId)
            ->setParameter('profile', $profileId)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
