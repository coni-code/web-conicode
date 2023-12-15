<?php

namespace App\Entity\Trello;

interface TrelloEntity
{
    public function getId(): ?string;
    public function setTrelloId(string $trelloId): void;
    public function getTrelloId(): ?string;
}
