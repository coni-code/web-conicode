<?php

declare(strict_types=1);

namespace App\Trello\Fetcher;

class CardFetcher extends AbstractFetcher
{
    private const CARDS = 'boards/{id}/cards';

    /**
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
