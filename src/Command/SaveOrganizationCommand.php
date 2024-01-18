<?php

declare(strict_types=1);

namespace App\Command;

use App\Trello\Executor\OrganizationExecutor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'save:organization',
    description: 'Save organization from Trello',
    aliases: ['sa:or'],
)]
class SaveOrganizationCommand extends Command
{
    public function __construct(private readonly OrganizationExecutor $executor)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->executor->execute($input, $output);

        return Command::SUCCESS;
    }
}
