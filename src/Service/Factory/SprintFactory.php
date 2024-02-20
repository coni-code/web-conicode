<?php

declare(strict_types=1);

namespace App\Service\Factory;

use App\Entity\Sprint;

class SprintFactory
{
    public static function createSprint(
        string $title,
        \DateTimeInterface $startDate,
        \DateTimeInterface $endDate,
        ?int $storyPoints = null,
        ?bool $isSuccessful = null,
    ): Sprint {
        $sprint = new Sprint();
        $sprint->setTitle($title);
        $sprint->setStartDate($startDate);
        $sprint->setEndDate($endDate);
        $sprint->setStoryPoints($storyPoints);
        $sprint->setIsSuccessful($isSuccessful);

        return $sprint;
    }
}
