<?php

declare(strict_types=1);

namespace App\Command;

use App\Trello\Executor\AbstractExecutor;
use App\Trello\Executor\BoardExecutor;
use App\Trello\Executor\BoardListExecutor;
use App\Trello\Executor\CardExecutor;
use App\Trello\Executor\MemberExecutor;
use App\Trello\Executor\OrganizationExecutor;
use App\Trello\Executor\PluginDataExecutor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
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
        private readonly PluginDataExecutor $pluginDataExecutor,
    ) {
        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new OutputFormatterStyle('yellow');
        $output->getFormatter()->setStyle('yellow', $style);

        $this->executeCommand($input, $output, $this->organizationExecutor);
        $this->executeCommand($input, $output, $this->boardExecutor);
        $this->executeCommand($input, $output, $this->memberExecutor);
        $this->executeCommand($input, $output, $this->boardListExecutor);
        $this->executeCommand($input, $output, $this->cardExecutor);
        $this->executeCommand($input, $output, $this->pluginDataExecutor);

        return Command::SUCCESS;
    }

    /**
     * @throws \Exception
     */
    private function executeCommand(
        InputInterface $input,
        OutputInterface $output,
        AbstractExecutor $executor,
    ): void {
        $output->writeln(' <yellow> > processing ' . get_class($executor) . '</yellow>');
        $executor->execute($input, $output);
    }
}
