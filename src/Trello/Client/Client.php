<?php

declare(strict_types=1);

namespace App\Trello\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Utils;

class Client
{
    const BASE_API_URL = 'https://api.trello.com/1/';

    public function __construct(
        private readonly ClientInterface $client,
        private readonly Config $config,
    ) {
    }

    private function renderUrl(string $requestPath, array $placeholders = [], array $fields = ['all']): string
    {
        return sprintf(
            '%s%s?key=%s&token=%s&fields=%s',
            self::BASE_API_URL,
            str_replace(array_keys($placeholders), array_values($placeholders), $requestPath),
            $this->config->getKey(),
            $this->config->getToken(),
            implode(',', $fields),
        );
    }

    private function getAuthorizationOptions(): array
    {
        return [RequestOptions::HEADERS => ['Accept' => 'application/json']];
    }

    public function get(string $path, string $id, array $fields = ['all']): array
    {
        $response = $this->client->request(
            'GET',
            $this->renderUrl(
                $path,
                ['{id}' => $id],
                $fields
            ),
            $this->getAuthorizationOptions()
        );

        if (($statusCode = $response->getStatusCode()) !== 200) {
            throw new \RuntimeException('Unable to get card from board', $statusCode);
        }

        return Utils::jsonDecode($response->getBody()->getContents(), true);
    }
}
