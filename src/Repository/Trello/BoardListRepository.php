<?php

declare(strict_types=1);

namespace App\Repository\Trello;

use App\Entity\Trello\Board;
use App\Entity\Trello\BoardList;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BoardList|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoardList|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoardList[]    findAll()
 * @method BoardList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardListRepository extends ServiceEntityRepository
{
    private const EXPIRATION_DAYS = 30;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoardList::class);
    }

    public function save(BoardList $boardList): bool
    {
        $em = $this->getEntityManager();
        $em->persist($boardList);
        $em->flush();

        return true;
    }
}
