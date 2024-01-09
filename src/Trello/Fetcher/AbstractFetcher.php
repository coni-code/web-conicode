<?php

declare(strict_types=1);

namespace App\Trello\Fetcher;

use App\Trello\Client\Client;

abstract class AbstractFetcher
{
    public function __construct(protected readonly Client $client)
    {
    }
}
