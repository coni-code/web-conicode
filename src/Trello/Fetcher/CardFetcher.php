<?php

declare(strict_types=1);

namespace App\Trello\Fetcher;

use GuzzleHttp\Exception\GuzzleException;

class CardFetcher extends AbstractFetcher
{
    private const CARDS = 'boards/{id}/cards';
    private const PLUGIN_DATA = 'cards/{id}/pluginData';

    /**
     * @return array<string>
     *
     * @throws GuzzleException
     */
    public function getCardsFromBoard(string $id): array
    {
        return $this->client->get(
            self::CARDS,
            $id,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getCardPluginData(string $id): array
    {
        return $this->client->get(
            self::PLUGIN_DATA,
            $id,
        );
    }
}
