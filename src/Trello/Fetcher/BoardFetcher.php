<?php

declare(strict_types=1);

namespace App\Trello\Fetcher;

use GuzzleHttp\Exception\GuzzleException;

class BoardFetcher extends AbstractFetcher
{
    private const BOARD = 'boards/{id}';

    /**
     * @return array<string>
     * @throws GuzzleException
     */
    public function getBoard(string $id): array
    {
        return $this->client->get(
            self::BOARD,
            $id,
        );
    }
}
