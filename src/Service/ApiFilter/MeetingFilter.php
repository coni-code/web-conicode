<?php

declare(strict_types=1);

namespace App\Service\ApiFilter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;

class MeetingFilter extends AbstractFilter
{
    private const USER_PROPERTY = 'user';
    private const USERS_PROPERTY = 'users';
    private const START_DATE_PROPERTY = 'startDate';
    private const END_DATE_PROPERTY = 'endDate';

    public function getDescription(string $resourceClass): array
    {
        return [
            self::USER_PROPERTY => [
                'property' => self::USER_PROPERTY,
                'type' => 'integer',
                'required' => false,
                'description' => 'Filter meetings by a single user ID',
            ],
            self::USERS_PROPERTY => [
                'property' => self::USERS_PROPERTY,
                'type' => 'array',
                'required' => false,
                'description' => 'Filter meetings by a list of user IDs',
            ],
            self::START_DATE_PROPERTY => [
                'property' => 'startDate',
                'type' => 'datetime',
                'required' => false,
                'description' => 'Filter meetings after or on this date',
            ],
            self::END_DATE_PROPERTY => [
                'property' => 'endDate',
                'type' => 'datetime',
                'required' => false,
                'description' => 'Filter meetings after or on this date',
            ],
        ];
    }

    protected function filterProperty(
        string $property,
        mixed $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = [],
    ): void {
        if (!$value) {
            return;
        }

        $alias = $queryBuilder->getRootAliases()[0];

        match ($property) {
            self::USER_PROPERTY => $this->applyUserFilter($queryBuilder, $alias, $value),
            self::USERS_PROPERTY => $this->applyUsersFilter($queryBuilder, $queryNameGenerator, $alias, $value),
            self::START_DATE_PROPERTY => $this->applyStartDateFilter($queryBuilder, $alias, $value),
            self::END_DATE_PROPERTY => $this->applyEndDateFilter($queryBuilder, $alias, $value),
            default => null
        };
    }

    private function applyUserFilter(QueryBuilder $queryBuilder, string $alias, mixed $value): void {
        $queryBuilder
            ->andWhere(sprintf(':user MEMBER OF %s.users', $alias))
            ->setParameter('user', $value);
    }

    private function applyUsersFilter(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $alias,
        mixed $value,
    ): void {
        $usersAlias = $queryNameGenerator->generateJoinAlias('users');
        $userIds = explode(',', $value);
        $queryBuilder
            ->leftJoin(sprintf('%s.users', $alias), $usersAlias)
            ->andWhere(sprintf('%s IN (:users)', $usersAlias))
            ->setParameter('users', $userIds);
    }

    private function applyStartDateFilter(QueryBuilder $queryBuilder, string $alias, mixed $value): void {
        $queryBuilder
            ->andWhere(sprintf('%s.startDate >= :startDate', $alias))
            ->setParameter('startDate', $value);
    }

    private function applyEndDateFilter(QueryBuilder $queryBuilder, string $alias, mixed $value): void {
        $queryBuilder
            ->andWhere(sprintf('%s.endDate <= :endDate', $alias))
            ->setParameter('endDate', $value);
    }
}
