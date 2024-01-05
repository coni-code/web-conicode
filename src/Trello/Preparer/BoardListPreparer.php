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

    /**
     * @param array $apiDatum
     * @return BoardList
     */
    public function prepareOne(array $apiDatum): BoardList
    {
        [
            'id' => $id,
            'name' => $name,
            'idBoard' => $idBoard,
        ] = $apiDatum;

        if (!$boardList = $this->boardListRepository->findOneBy(['id' => $id])) {
            $boardList = new BoardList();
            $boardList->setId($id);
        }

        $name !== $boardList->getName() && $boardList->setName($name);

        if ($board = $this->boardRepository->findOneBy(['id' => $idBoard])) {
            $boardList->setBoard($board);
        }

        return $boardList;
    }
}
