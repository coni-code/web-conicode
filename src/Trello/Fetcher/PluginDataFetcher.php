<?php

declare(strict_types=1);

namespace App\Trello\Fetcher;

use GuzzleHttp\Exception\GuzzleException;

class PluginDataFetcher extends AbstractFetcher
{
    private const PLUGIN_DATA = 'cards/{id}/pluginData';

    /**
     * @return array<string>
     * @throws GuzzleException
     */
    public function getPluginDataFromCard(string $id): array
    {
        return $this->client->get(
            self::PLUGIN_DATA,
            $id,
        );
    }
}
