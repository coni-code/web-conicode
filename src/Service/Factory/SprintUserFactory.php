<?php

declare(strict_types=1);

namespace App\Service\Factory;

use App\Entity\SprintUser;

class SprintUserFactory
{
    public static function createSprintUser(
        int $availabilityInHours,
    ): SprintUser {
        $sprint = new SprintUser();
        $sprint->setAvailabilityInHours($availabilityInHours);

        return $sprint;
    }
}
