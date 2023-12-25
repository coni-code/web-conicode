<?php

namespace App\Entity\Trello;

interface TrelloEntity
{
    public function getId(): ?string;
    public function setId(string $id): void;
}
