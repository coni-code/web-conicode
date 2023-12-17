<?php

namespace App\Trello\Fetcher;

class OrganizationFetcher extends AbstractFetcher
{
    private const ORGANIZATION = 'organizations/{id}';

    public function getOrganization(string $id): array
    {
        return $this->client->get(
            self::ORGANIZATION,
            $id,
        );
    }
}
