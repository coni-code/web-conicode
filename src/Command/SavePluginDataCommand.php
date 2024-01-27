<?php

declare(strict_types=1);

namespace App\Command;

use App\Trello\Executor\PluginDataExecutor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'save:plugin:data',
    description: 'Save plugin data from Trello',
    aliases: ['sa:pl:da'],
)]
class SavePluginDataCommand extends Command
{
    public function __construct(private readonly PluginDataExecutor $executor)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->executor->execute($input, $output);

        return Command::SUCCESS;
    }
}
