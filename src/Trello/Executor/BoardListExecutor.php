<?php

declare(strict_types=1);

namespace App\Trello\Executor;

use App\Trello\Client\Config;
use App\Trello\Fetcher\BoardListFetcher;
use App\Trello\Preparer\BoardListPreparer;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BoardListExecutor extends AbstractExecutor
{
    public function __construct(
        private readonly BoardListFetcher $fetcher,
        private readonly BoardListPreparer $preparer,
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

        $boardListDatum = $this->fetcher->getListsFromBoard($boardId);
        $boardList = $this->preparer->prepare($boardListDatum);

        $this->save($boardList);
    }
}
