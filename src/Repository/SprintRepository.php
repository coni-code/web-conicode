<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Sprint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sprint>
 *
 * @method Sprint|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sprint|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sprint[]    findAll()
 * @method Sprint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SprintRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sprint::class);
    }

    public function save(Sprint $sprint): bool
    {
        $em = $this->getEntityManager();
        $em->persist($sprint);
        $em->flush();

        return true;
    }

    public function delete(Sprint $sprint): bool
    {
        $em = $this->getEntityManager();
        $em->remove($sprint);
        $em->flush();

        return true;
    }

    public function findLatestSprint(): ?Sprint
    {
        $currentDate = new \DateTime();
        $currentDate->setTime(0, 0);

        return $this->createQueryBuilder('s')
            ->where('s.startDate <= :endOfDay')
            ->andWhere('s.endDate >= :startOfDay')
            ->setParameter('startOfDay', $currentDate)
            ->setParameter('endOfDay', $currentDate->format('Y-m-d 23:59:59'))
            ->orderBy('s.endDate', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllOrderedByStartDate(): array
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.startDate', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
