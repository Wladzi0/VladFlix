<?php

namespace App\Repository;

use App\Entity\File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method File|null find($id, $lockMode = null, $lockVersion = null)
 * @method File|null findOneBy(array $criteria, array $orderBy = null)
 * @method File[]    findAll()
 * @method File[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);
    }

    public function findFileOfFilm($film)
    {
        return $this->createQueryBuilder('f')
            ->leftJoin('f.film', 'film' )
            ->where('film.id = :film')
            ->setParameter('film',$film)
            ->getQuery()
            ->getSingleResult();
    }
    public function findFileOfEpisode($episodeId)
    {
        return $this->createQueryBuilder('f')
            ->leftJoin('f.episode', 'episode' )
            ->where('episode.id = :episode')
            ->setParameter('episode',$episodeId)
            ->getQuery()
            ->getSingleResult();
    }
}
