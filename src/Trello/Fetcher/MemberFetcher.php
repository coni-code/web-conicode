<?php

namespace App\Trello\Fetcher;

class MemberFetcher extends AbstractFetcher
{
    private const MEMBERS = 'boards/{id}/members';
    private const MEMBER = 'members/{id}';

    public function getMember(string $id): array
    {
        return $this->client->get(
            self::MEMBER,
            $id,
        );
    }

    public function getMembersIdFromBoard(string $id): array
    {
        return $this->client->get(
            self::MEMBERS,
            $id,
            ['id']
        );
    }

    public function getMembersFromBoard(string $id): array
    {
        return $this->client->get(
            self::MEMBERS,
            $id,
        );
    }
}
