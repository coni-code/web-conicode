<?php

declare(strict_types=1);

namespace App\Trello\Executor;

use App\Repository\Trello\BoardListRepository;
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
        private readonly BoardListRepository $boardListRepository,
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

        $boardListData = $this->fetcher->getListsFromBoard($boardId);
        $boardLists = $this->preparer->prepare($boardListData);
        $existingLists = $this->boardListRepository->findAll();

        $existingListIds = array_map(fn($list) => $list->getId(), $existingLists);
        $fetchedListIds = array_map(fn($list) => $list->getId(), $boardLists->toArray());
        $listsNotFetched = array_diff($existingListIds, $fetchedListIds);

        foreach ($listsNotFetched as $listId) {
            $listToUpdate = $this->boardListRepository->findOneBy(['id' => $listId]);

            if ($listToUpdate) {
                $listToUpdate->setBoard(null);
                $this->boardListRepository->save($listToUpdate);
            }
        }

        $this->save($boardLists);
    }
}
