<?php

namespace App\Command;

use App\Trello\Executor\BoardExecutor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'save:board',
    description: 'Save board from Trello',
    aliases: ['sa:bo'],
)]
class SaveBoardCommand extends Command
{
    public function __construct(private readonly BoardExecutor $executor)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->executor->execute($input, $output);
        return Command::SUCCESS;
    }
}
