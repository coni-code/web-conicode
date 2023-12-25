<?php

namespace App\Trello\Fetcher;

class BoardListFetcher extends AbstractFetcher
{
    private const LISTS = 'board/{id}/lists';

    public function getListsFromBoard(string $id): array
    {
        return $this->client->get(
            self::LISTS,
            $id,
        );
    }
}
