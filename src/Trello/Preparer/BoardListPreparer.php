<?php

namespace App\Trello\Preparer;

use App\Entity\Trello\Board;
use App\Entity\Trello\BoardList;
use App\Repository\Trello\BoardListRepository;
use App\Repository\Trello\BoardRepository;
use App\Repository\Trello\OrganizationRepository;

class BoardListPreparer extends AbstractPreparer
{
    public function __construct(
        private readonly BoardListRepository $boardListRepository,
        private readonly BoardRepository $boardRepository,
    ) {
    }

    public function prepareOne(array $apiDatum): BoardList
    {
        [
            'id' => $id,
            'name' => $name,
            'idOrganization' => $idOrganization,
        ] = $apiDatum;

        if ($boardList = $this->boardListRepository->findOneBy(['id' => $id])) {
            $id !== $boardList->getId() && $boardList->setId($id);
            $name !== $boardList->getName() && $boardList->setName($name);
        } else {
            $boardList = new BoardList();
            $boardList->setId($id);
            $boardList->setName($name);

            if ($board = $this->boardRepository->findOneBy(['id' => $idOrganization])) {
                $boardList->setBoard($board);
            }
        }

        return $boardList;
    }
}
