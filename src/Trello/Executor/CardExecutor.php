<?php

declare(strict_types=1);

namespace App\Trello\Executor;

use App\Repository\Trello\CardRepository;
use App\Trello\Client\Config;
use App\Trello\Fetcher\CardFetcher;
use App\Trello\Preparer\CardPreparer;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CardExecutor extends AbstractExecutor
{
    public function __construct(
        private readonly CardFetcher $fetcher,
        private readonly CardPreparer $preparer,
        private readonly CardRepository $cardRepository,
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

        $cardData = $this->fetcher->getCardsFromBoard($boardId);
        $cards = $this->preparer->prepare($cardData);
        $existingCards = $this->cardRepository->findAll();

        $existingCardIds = array_map(fn ($card) => $card->getId(), $existingCards);
        $fetchedCardIds = array_map(fn ($card) => $card->getId(), $cards->toArray());
        $cardsNotFetched = array_diff($existingCardIds, $fetchedCardIds);

        foreach ($cardsNotFetched as $cardId) {
            $cardToUpdate = $this->cardRepository->findOneBy(['id' => $cardId]);

            if ($cardToUpdate) {
                $cardToUpdate->setBoardList(null);
                $this->cardRepository->save($cardToUpdate);
            }
        }

        $this->save($cards);
    }
}
