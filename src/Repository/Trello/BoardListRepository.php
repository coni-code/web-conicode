<?php

namespace App\Repository\Trello;

use App\Entity\Trello\BoardList;
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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoardList::class);
    }
}
