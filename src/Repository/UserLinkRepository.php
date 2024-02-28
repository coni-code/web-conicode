<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UserLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserLink>
 *
 * @method UserLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserLink[]    findAll()
 * @method UserLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserLinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserLink::class);
    }
}
