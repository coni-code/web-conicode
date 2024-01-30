<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Sprint;
use App\Exception\NotFoundException;
use App\Repository\SprintRepository;

class SprintService
{
    public function __construct(
       private readonly SprintRepository $sprintRepository,
    ) {
    }

    public function save(Sprint $sprint): void
    {
        $this->sprintRepository->save($sprint);
    }

    public function delete(string $id): bool
    {
        if (!$sprint = $this->sprintRepository->find($id)) {
            throw new NotFoundException();
        }

        return $this->sprintRepository->delete($sprint);
    }
}
