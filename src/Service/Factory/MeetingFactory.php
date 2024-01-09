<?php

declare(strict_types=1);

namespace App\Service\Factory;

use App\Entity\Meeting;
use App\Enum\MeetingStatusEnum;
use DateTimeInterface;

class MeetingFactory
{
    public static function createMeeting(
        string $title,
        string $description,
        DateTimeInterface $startDate,
        DateTimeInterface $endDate,
        MeetingStatusEnum $status
    ): Meeting
    {
        $meeting = new Meeting();
        $meeting->setTitle($title);
        $meeting->setDescription($description);
        $meeting->setStartDate($startDate);
        $meeting->setEndDate($endDate);
        $meeting->setStatus($status);

        return $meeting;
    }
}
