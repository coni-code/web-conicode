<?php

declare(strict_types=1);

namespace App\Trello\Executor;

use App\Trello\Client\Config;
use App\Trello\Fetcher\BoardFetcher;
use App\Trello\Preparer\BoardPreparer;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BoardExecutor extends AbstractExecutor
{
    public function __construct(
        private readonly BoardFetcher $fetcher,
        private readonly BoardPreparer $preparer,
        private readonly Config $config,
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function doExecute(?InputInterface $input, ?OutputInterface $output): void
    {
        if (!$boardId = $this->config->getBoardId()) {
            return;
        }

        $boardDatum = $this->fetcher->getBoard($boardId);
        $board = $this->preparer->prepareOne($boardDatum);

        $this->saveOne($board);
    }
}
