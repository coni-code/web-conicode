<?php

declare(strict_types=1);

namespace App\Trello\Executor;

use App\Trello\Client\Config;
use App\Trello\Fetcher\OrganizationFetcher;
use App\Trello\Preparer\OrganizationPreparer;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OrganizationExecutor extends AbstractExecutor
{
    public function __construct(
        private readonly OrganizationFetcher $fetcher,
        private readonly OrganizationPreparer $preparer,
        private readonly Config $config,
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function doExecute(?InputInterface $input, ?OutputInterface $output): void
    {
        if (!$organizationId = $this->config->getOrganizationId()) {
            return;
        }

        $organizationDatum = $this->fetcher->getOrganization($organizationId);
        $organization = $this->preparer->prepareOne($organizationDatum);

        $this->saveOne($organization);
    }
}
