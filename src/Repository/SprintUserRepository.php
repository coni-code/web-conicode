<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SprintUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SprintUser>
 *
 * @method SprintUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method SprintUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method SprintUser[]    findAll()
 * @method SprintUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SprintUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SprintUser::class);
    }
}
