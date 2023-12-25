<?php

namespace App\Trello\Executor;

use App\Repository\Trello\BoardRepository;
use App\Trello\Client\Config;
use App\Trello\Fetcher\MemberFetcher;
use App\Trello\Preparer\MemberPreparer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MemberExecutor extends AbstractExecutor
{
    public function __construct(
        private readonly MemberFetcher $fetcher,
        private readonly MemberPreparer $preparer,
        private readonly BoardRepository $boardRepository,
        private readonly Config $config,
    ) {
    }

    public function doExecute(?InputInterface $input, ?OutputInterface $output): void
    {
        if (!$this->config->getBoardId()) {
            return;
        }

        $board = $this->boardRepository->findOneBy(['id' => $this->config->getBoardId()]);
        $memberData = $this->fetcher->getMembersFromBoard($this->config->getBoardId());
        $members = $this->preparer->prepare($memberData);
        $members = $this->preparer->addBoard($members, $board);

        $this->save($members);
    }
}
