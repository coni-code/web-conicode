<?php

namespace App\Trello\Fetcher;

class BoardListFetcher extends AbstractFetcher
{
    private const LISTS = 'board/{id}/lists';

    /**
     * @param string $id
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
