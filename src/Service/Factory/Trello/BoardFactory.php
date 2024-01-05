<?php

namespace App\Service\Factory\Trello;

use App\Entity\Trello\Board;

class BoardFactory
{
    public static function createBoard(
        string $id,
        string $name
    ): Board
    {
        $board = new Board();
        $board->setId($id);
        $board->setName($name);

        return $board;
    }
}