<?php

namespace App\Trello\Fetcher;

class OrganizationFetcher extends AbstractFetcher
{
    private const ORGANIZATION = 'organizations/{id}';

    /**
     * @param string $id
     * @return array<string>
     */
    public function getOrganization(string $id): array
    {
        return $this->client->get(
            self::ORGANIZATION,
            $id,
        );
    }
}
