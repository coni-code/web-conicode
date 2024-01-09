<?php

declare(strict_types=1);

namespace App\Trello\Fetcher;

class MemberFetcher extends AbstractFetcher
{
    private const MEMBERS = 'boards/{id}/members';
    private const MEMBER = 'members/{id}';

    /**
     * @return array<string>
     */
    public function getMember(string $id): array
    {
        return $this->client->get(
            self::MEMBER,
            $id,
        );
    }

    /**
     * @return array<string>
     */
    public function getMembersIdFromBoard(string $id): array
    {
        return $this->client->get(
            self::MEMBERS,
            $id,
            ['id'],
        );
    }

    /**
     * @return array<string>
     */
    public function getMembersFromBoard(string $id): array
    {
        return $this->client->get(
            self::MEMBERS,
            $id,
        );
    }
}
