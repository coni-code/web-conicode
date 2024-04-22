<?php

declare(strict_types=1);

namespace App\Repository\Trello;

use App\Entity\Trello\Card;
use App\Entity\User;
use App\Enum\SprintListNameEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Card|null find($id, $lockMode = null, $lockVersion = null)
 * @method Card|null findOneBy(array $criteria, array $orderBy = null)
 * @method Card[]    findAll()
 * @method Card[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Card::class);
    }

    public function findToDoCardsAssignedToUser(User $user): array
    {
        if (!$member = $user->getMember()) {
            return [];
        }

        $activeListNames = SprintListNameEnum::getInProgressListNames();

        return $this->createQueryBuilder('c')
            ->innerJoin('c.members', 'm')
            ->innerJoin('c.boardList', 'l')
            ->where('m.id = :member')
            ->andWhere('l.name IN (:listNames)')
            ->setParameter('member', $member)
            ->setParameter('listNames', $activeListNames)
            ->getQuery()
            ->getResult();
    }
}
