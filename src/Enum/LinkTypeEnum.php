<?php

declare(strict_types=1);

namespace App\Enum;

enum LinkTypeEnum: string
{
    case GITHUB = 'github';
    case GITLAB = 'gitlab';
    case LINKEDIN = 'linkedin';
    case WEBSITE = 'website';
    case YOUTUBE = 'youtube';

    public static function getChoices(): array
    {
        return [
            self::GITHUB->value => self::GITHUB,
            self::GITLAB->value => self::GITLAB,
            self::LINKEDIN->value => self::LINKEDIN,
            self::WEBSITE->value => self::WEBSITE,
            self::YOUTUBE->value => self::YOUTUBE,
        ];
    }
}
