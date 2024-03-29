<?php

declare(strict_types=1);

namespace App\Trello\Executor;

use App\Entity\Trello\TrelloEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Service\Attribute\Required;

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
     * @throws \Exception
     */
    final public function execute(?InputInterface $input, ?OutputInterface $output): void
    {
        try {
            $this->doExecute($input, $output);
        } catch (\Throwable $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param Collection<TrelloEntity> $collection
     */
    protected function save(Collection $collection): void
    {
        $em = $this->doctrine->getManager();
        foreach ($collection as $entity) {
            $em->persist($entity);
        }
        $em->flush();
    }

    protected function saveOne(TrelloEntity $entity): void
    {
        $em = $this->doctrine->getManager();
        $em->persist($entity);
        $em->flush();
    }

    /** @phpstan-ignore-next-line
     *  ignoring unused method because it may be useful in future development
     */
    private function getExecutorClassName(): string
    {
        return substr(strrchr(get_class($this), '\\'), 1);
    }
}
