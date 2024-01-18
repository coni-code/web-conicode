<?php

declare(strict_types=1);

namespace App\Trello\Preparer;

use App\Entity\Trello\Organization;
use App\Repository\Trello\OrganizationRepository;

class OrganizationPreparer extends AbstractPreparer
{
    public function __construct(private readonly OrganizationRepository $repository)
    {
    }

    public function prepareOne(array $apiDatum): Organization
    {
        [
            'id' => $id,
            'name' => $name,
            'displayName' => $displayName,
            'desc' => $description,
            'url' => $url,
        ] = $apiDatum;

        if (!$organization = $this->repository->findOneBy(['id' => $id])) {
            $organization = new Organization();
            $organization->setId($id);
        }

        $id !== $organization->getId() && $organization->setId($id);
        $name !== $organization->getName() && $organization->setName($name);
        $displayName !== $organization->getDisplayName() && $organization->setDisplayName($displayName);
        $description !== $organization->getDescription() && $organization->setDescription($description);
        $url !== $organization->getUrl() && $organization->setUrl($url);

        return $organization;
    }
}
