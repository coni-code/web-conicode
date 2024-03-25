<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Dictionary\PositionDictionary;
use App\Exception\NotFoundException;
use App\Repository\PositionDictionaryRepository;

class PositionDictionaryService
{
    public function __construct(
        private readonly PositionDictionaryRepository $positionDictionaryRepository,
    ) {
    }

    public function save(PositionDictionary $sprint): void
    {
        $this->positionDictionaryRepository->save($sprint);
    }

    public function delete(string $id): bool
    {
        if (!$sprint = $this->positionDictionaryRepository->find($id)) {
            throw new NotFoundException();
        }

        return $this->positionDictionaryRepository->delete($sprint);
    }
}
