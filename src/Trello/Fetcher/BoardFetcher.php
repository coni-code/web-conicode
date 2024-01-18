<?php

declare(strict_types=1);

namespace App\Trello\Fetcher;

class BoardFetcher extends AbstractFetcher
{
    private const BOARD = 'boards/{id}';

    /**
     * @return array<string>
     */
    public function getBoard(string $id): array
    {
        return $this->client->get(
            self::BOARD,
            $id,
        );
    }
}
