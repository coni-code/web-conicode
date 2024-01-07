<?php

namespace App\Trello\Fetcher;

class CardFetcher extends AbstractFetcher
{
    private const CARDS = 'boards/{id}/cards';

    /**
     * @param string $id
     * @return array<string>
     */
    public function getCardsFromBoard(string $id): array
    {
        return $this->client->get(
            self::CARDS,
            $id,
        );
    }
}
