<?php

declare(strict_types=1);

namespace App\Trello\Fetcher;

class PluginDataFetcher extends AbstractFetcher
{
    private const PLUGIN_DATA = 'cards/{id}/pluginData';

    /**
     * @return array<string>
     */
    public function getPluginDataFromCard(string $id): array
    {
        return $this->client->get(
        self::PLUGIN_DATA,
            $id
        );
    }
}
