<?php

namespace App\Trello\Fetcher;

class BoardFetcher extends AbstractFetcher
{
    private const BOARD = 'boards/{id}';

    public function getBoard(string $id): array
    {
        return $this->client->get(
            self::BOARD,
            $id,
        );
    }
}
