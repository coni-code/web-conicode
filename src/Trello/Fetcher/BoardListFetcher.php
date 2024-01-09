<?php

declare(strict_types=1);

namespace App\Trello\Fetcher;

class BoardListFetcher extends AbstractFetcher
{
    private const LISTS = 'board/{id}/lists';

    /**
     * @return array<string>
     */
    public function getListsFromBoard(string $id): array
    {
        return $this->client->get(
            self::LISTS,
            $id,
        );
    }
}
