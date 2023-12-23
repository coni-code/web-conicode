<?php

namespace App\Trello\Preparer;

use App\Entity\Trello\Board;
use App\Repository\Trello\BoardRepository;
use App\Repository\Trello\OrganizationRepository;

class BoardPreparer extends AbstractPreparer
{
    public function __construct(
        private readonly BoardRepository $boardRepository,
        private readonly OrganizationRepository $organizationRepository,
    ) {
    }

    public function prepareOne(array $apiDatum): Board
    {
        [
            'id' => $id,
            'name' => $name,
            'idOrganization' => $idOrganization,
        ] = $apiDatum;

        if (!$board = $this->boardRepository->findOneBy(['id' => $id])) {
            $board = new Board();
            $board->setId($id);
        }

        $id !== $board->getId() && $board->setId($id);
        $name !== $board->getName() && $board->setName($name);

        if ($organization = $this->organizationRepository->findOneBy(['id' => $idOrganization])) {
            $board->setOrganization($organization);
        }

        return $board;
    }
}
