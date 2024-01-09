<?php

declare(strict_types=1);

namespace App\Trello\Client;

class Config
{
    public function __construct(
        private readonly string $key,
        private readonly string $token,
        private readonly string $boardId,
        private readonly string $organizationId,
    ) {
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getOrganizationId(): string
    {
        return $this->organizationId;
    }

    public function getBoardId(): string
    {
        return $this->boardId;
    }
}
