<?php

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

        if ($organization = $this->repository->findOneBy(['id' => $id])) {
            $id !== $organization->getId() && $organization->setId($id);
            $name !== $organization->getName() && $organization->setName($name);
            $displayName !== $organization->getDisplayName() && $organization->setDisplayName($displayName);
            $description !== $organization->getDescription() && $organization->setDescription($description);
            $url !== $organization->getUrl() && $organization->setUrl($url);
        } else {
            $organization = new Organization();
            $organization->setId($id);
            $organization->setName($name);
            $organization->setDisplayName($displayName);
            $organization->setDescription($description);
            $organization->setUrl($url);
        }

        return $organization;
    }
}
