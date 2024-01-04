<?php

namespace App\Service\ApiFilter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;

class MeetingFilter extends AbstractFilter
{
    private const USER_PROPERTY = 'user';
    private const USERS_PROPERTY = 'users';

    protected function filterProperty(
        string $property,
        mixed $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = []
    ): void {
        if (!$value) {
            return;
        }

        $alias = $queryBuilder->getRootAliases()[0];

        if (self::USER_PROPERTY === $property) {
            $queryBuilder
                ->andWhere(sprintf(':user MEMBER OF %s.users', $alias))
                ->setParameter('user', $value);
        }

        if (self::USERS_PROPERTY === $property) {
            $usersAlias = $queryNameGenerator->generateJoinAlias('users');
            $userIds = explode(',', $value);
            $queryBuilder
                ->leftJoin(sprintf('%s.users', $alias), $usersAlias)
                ->andWhere(sprintf('%s IN (:users)', $usersAlias))
                ->setParameter('users', $userIds);
        }
    }

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
        ];
    }
}
