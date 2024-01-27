<?php

declare(strict_types=1);

namespace App\Trello\Fetcher;

use GuzzleHttp\Exception\GuzzleException;

class MemberFetcher extends AbstractFetcher
{
    private const MEMBERS = 'boards/{id}/members';
    private const MEMBER = 'members/{id}';

    /**
     * @return array<string>
     *
     * @throws GuzzleException
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
     *
     * @throws GuzzleException
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
     *
     * @throws GuzzleException
     */
    public function getMembersFromBoard(string $id): array
    {
        return $this->client->get(
            self::MEMBERS,
            $id,
        );
    }
}
