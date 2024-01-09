<?php

declare(strict_types=1);

namespace App\Trello\Downloader;

use App\Entity\Trello\Member;
use App\Exception\AvatarDownloadException;
use App\Exception\TrelloStorageException;
use Doctrine\Common\Collections\Collection;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;

class MemberAvatarDownloader
{
    public function __construct(
        private readonly FilesystemOperator $trelloStorage,
        private readonly Client $client,
    ) {
    }

    /**
     * @param Collection<Member> $members
     *
     * @throws TrelloStorageException
     * @throws AvatarDownloadException
     */
    public function downloadAvatars(Collection $members): bool
    {
        foreach ($members as $member) {
            if (!$avatarUrl = $member->getAvatarUrl()) {
                continue;
            }

            try {
                $response = $this->client->get(sprintf('%s/170.png', $avatarUrl));
                if (200 === $response->getStatusCode()) {
                    $imageContent = $response->getBody()->getContents();
                    $this->trelloStorage->write('avatars/' . $member->getAvatarHash() . '.png', $imageContent);
                }
            } catch (GuzzleException $exception) {
                throw new AvatarDownloadException($exception->getMessage(), $exception->getCode(), $exception);
            } catch (FilesystemException $exception) {
                throw new TrelloStorageException($exception->getMessage(), $exception->getCode(), $exception);
            }
        }

        return true;
    }
}
