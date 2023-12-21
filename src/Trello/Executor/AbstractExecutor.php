<?php

namespace App\Trello\Executor;

use App\Entity\Trello\TrelloEntity;
use Exception;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Throwable;

abstract class AbstractExecutor
{
    protected OutputInterface $output;
    protected ManagerRegistry $doctrine;

    #[Required]
    public function setDependencies(ManagerRegistry $doctrine): void
    {
        $this->doctrine = $doctrine;
    }

    abstract public function doExecute(?InputInterface $input, ?OutputInterface $output);

    /**
     * @throws Exception
     */
    final public function execute(?InputInterface $input, ?OutputInterface $output): void
    {
        try {
            $this->doExecute($input, $output);
        } catch (Throwable $exception) {
            throw new Exception($exception);
        }
    }

    protected function save(TrelloEntity $entity): void
    {
        $em = $this->doctrine->getManager();
        $em->persist($entity);
        $em->flush();
    }

    private function getExecutorClassName(): string
    {
        return substr(strrchr(get_class($this), '\\'), 1);
    }
}
