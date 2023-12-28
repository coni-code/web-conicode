<?php

namespace App\Enum;

use Symfony\Component\Translation\TranslatableMessage;

enum MeetingStatusEnum: string
{
    case STATUS_PENDING   = "pending";
    case STATUS_CONFIRMED = "confirmed";

    public static function getChoices(): array
    {

        return [
            (new TranslatableMessage("admin.meeting.status.pending"))
                ->getMessage() => self::STATUS_PENDING,
            (new TranslatableMessage("admin.meeting.status.confirmed"))
                ->getMessage() => self::STATUS_CONFIRMED
        ];
    }
}
