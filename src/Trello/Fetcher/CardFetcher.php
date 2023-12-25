<?php

namespace App\Trello\Fetcher;

class CardFetcher extends AbstractFetcher
{
    private const CARDS = 'boards/{id}/cards';

    public function getCardsFromBoard(string $id): array
    {
        return $this->client->get(
            self::CARDS,
            $id,
        );
    }
}
