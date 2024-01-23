<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Meeting;
use App\Entity\User;
use App\Enum\MeetingStatusEnum;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Meeting>
 *
 * @method Meeting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meeting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meeting[]    findAll()
 * @method Meeting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meeting::class);
    }

    public function findClosestMeetingForUser(User $user): ?Meeting
    {
        return $this->createQueryBuilder('m')
            ->where(':user MEMBER OF m.users')
            ->andWhere('m.startDate > :currentDateTime')
            ->andWhere('m.status = :status')
            ->setParameter('user', $user)
            ->setParameter('currentDateTime', new DateTime())
            ->setParameter('status',  MeetingStatusEnum::STATUS_CONFIRMED)
            ->orderBy('m.startDate', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
