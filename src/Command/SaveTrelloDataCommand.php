<?php

declare(strict_types=1);

namespace App\Command;

use App\Trello\Executor\BoardExecutor;
use App\Trello\Executor\BoardListExecutor;
use App\Trello\Executor\CardExecutor;
use App\Trello\Executor\MemberExecutor;
use App\Trello\Executor\OrganizationExecutor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'save:trello',
    description: 'Save all data from Trello',
    aliases: ['sa:tr'],
)]
class SaveTrelloDataCommand extends Command
{
    public function __construct(
        private readonly OrganizationExecutor $organizationExecutor,
        private readonly BoardExecutor $boardExecutor,
        private readonly MemberExecutor $memberExecutor,
        private readonly BoardListExecutor $boardListExecutor,
        private readonly CardExecutor $cardExecutor,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->organizationExecutor->execute($input, $output);
        $this->boardExecutor->execute($input, $output);
        $this->memberExecutor->execute($input, $output);
        $this->boardListExecutor->execute($input, $output);
        $this->cardExecutor->execute($input, $output);
        return Command::SUCCESS;
    }
}
