<?php

declare(strict_types=1);

namespace App\Trello\Fetcher;

use GuzzleHttp\Exception\GuzzleException;

class BoardListFetcher extends AbstractFetcher
{
    private const LISTS = 'board/{id}/lists';

    /**
     * @return array<string>
     *
     * @throws GuzzleException
     */
    public function getListsFromBoard(string $id): array
    {
        return $this->client->get(
            self::LISTS,
            $id,
        );
    }
}
