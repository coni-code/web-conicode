<?php

declare(strict_types=1);

namespace App\Trello\Executor;

use App\Repository\Trello\CardRepository;
use App\Trello\Client\Config;
use App\Trello\Fetcher\PluginDataFetcher;
use App\Trello\Preparer\CardPreparer;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PluginDataExecutor extends AbstractExecutor
{
    public function __construct(
        private readonly Config $config,
        private readonly CardRepository $cardRepository,
        private readonly PluginDataFetcher $fetcher,
        private readonly CardPreparer $preparer,
    ) {
    }

    public function doExecute(?InputInterface $input, ?OutputInterface $output): void
    {
        $estimationPluginId = $this->config->getEstimationPluginId();
        $cards = new ArrayCollection();
        foreach ($this->cardRepository->findAll() as $card) {
            $pluginData = $this->fetcher->getPluginDataFromCard($card->getId());
            $cards->add($this->preparer->prepareCardEstimation($card, $pluginData, $estimationPluginId));
        }

        $this->save($cards);
    }
}
