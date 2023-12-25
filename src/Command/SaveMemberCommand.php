<?php

namespace App\Command;

use App\Trello\Executor\MemberExecutor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'save:member',
    description: 'Save member from Trello',
    aliases: ['sa:me'],
)]
class SaveMemberCommand extends Command
{
    public function __construct(private readonly MemberExecutor $executor)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->executor->execute($input, $output);
        return Command::SUCCESS;
    }
}
