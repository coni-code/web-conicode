<?php

namespace App\Service\Factory\Trello;

use App\Entity\Trello\BoardList;

class BoardListFactory
{
    public static function createBoardList(
        string $id,
        string $name,
        bool $visible,
    ): BoardList
    {
        $boardList = new BoardList();
        $boardList->setId($id);
        $boardList->setName($name);
        $boardList->setVisible($visible);

        return $boardList;
    }
}