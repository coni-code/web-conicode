<?php

declare(strict_types=1);

namespace App\Service\Factory\Trello;

use App\Entity\Trello\Organization;

class OrganizationFactory
{
    public static function createOrganization(
        string $id,
        string $name,
        string $displayName,
        string $description,
        string $url
    ): Organization {
        $organization = new Organization();

        $organization->setId($id);
        $organization->setName($name);
        $organization->setDisplayName($displayName);
        $organization->setDescription($description);
        $organization->setUrl($url);

        return $organization;
    }
}
