<?php

declare(strict_types=1);

namespace App\Trello\Fetcher;

class OrganizationFetcher extends AbstractFetcher
{
    private const ORGANIZATION = 'organizations/{id}';

    /**
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
