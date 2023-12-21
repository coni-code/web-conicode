<?php

namespace App\Trello\Executor;

use App\Trello\Client\Config;
use App\Trello\Fetcher\BoardFetcher;
use App\Trello\Preparer\BoardPreparer;
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

    public function doExecute(?InputInterface $input, ?OutputInterface $output): void
    {
        if (!$boardId = $this->config->getBoardId()) {
            return;
        }

        $boardDatum = $this->fetcher->getBoard($boardId);
        $board = $this->preparer->prepareOne($boardDatum);

        $this->save($board);
    }
}
