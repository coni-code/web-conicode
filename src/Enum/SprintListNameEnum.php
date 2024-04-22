<?php

declare(strict_types=1);

namespace App\Enum;

enum SprintListNameEnum: string
{
    private const SPRINT_BACKLOG = 'Sprint Backlog 🧱';
    private const IN_PROGRESS = 'In progress 🧐';
    private const QA_WAITING = 'QA Waiting ⏳';
    private const REVIEW = 'Review 👀';
    private const DONE = 'Done';

    public static function getChoices(): array
    {
        return [
            self::SPRINT_BACKLOG,
            self::IN_PROGRESS,
            self::QA_WAITING,
            self::REVIEW,
            self::DONE,
        ];
    }

    public static function getInProgressListNames(): array
    {
        return [
            self::SPRINT_BACKLOG,
            self::IN_PROGRESS,
            self::QA_WAITING,
            self::REVIEW,
        ];
    }
}
