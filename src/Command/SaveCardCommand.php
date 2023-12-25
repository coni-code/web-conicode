<?php

namespace App\Command;

use App\Trello\Executor\CardExecutor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'save:card',
    description: 'Save card from Trello',
    aliases: ['sa:ca'],
)]
class SaveCardCommand extends Command
{
    public function __construct(private readonly CardExecutor $executor)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->executor->execute($input, $output);
        return Command::SUCCESS;
    }
}
