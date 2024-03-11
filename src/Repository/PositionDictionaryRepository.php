<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Dictionary\PositionDictionary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PositionDictionary>
 *
 * @method PositionDictionary|null find($id, $lockMode = null, $lockVersion = null)
 * @method PositionDictionary|null findOneBy(array $criteria, array $orderBy = null)
 * @method PositionDictionary[]    findAll()
 * @method PositionDictionary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PositionDictionaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PositionDictionary::class);
    }
}
