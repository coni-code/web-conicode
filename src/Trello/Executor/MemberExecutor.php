<?php

declare(strict_types=1);

namespace App\Trello\Executor;

use App\Exception\AvatarDownloadException;
use App\Exception\TrelloStorageException;
use App\Repository\Trello\BoardRepository;
use App\Trello\Client\Config;
use App\Trello\Downloader\MemberAvatarDownloader;
use App\Trello\Fetcher\MemberFetcher;
use App\Trello\Preparer\MemberPreparer;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MemberExecutor extends AbstractExecutor
{
    public function __construct(
        private readonly MemberFetcher $fetcher,
        private readonly MemberPreparer $preparer,
        private readonly BoardRepository $boardRepository,
        private readonly Config $config,
        private readonly MemberAvatarDownloader $downloader,
    ) {
    }

    /**
     * @throws AvatarDownloadException
     * @throws TrelloStorageException
     * @throws GuzzleException
     */
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

        $this->downloader->downloadAvatars($members);
    }
}
