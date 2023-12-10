<?php

namespace App\Enum;

enum RoleEnum: int
{
    case ROLE_USER         = 0;
    case ROLE_ADMIN        = 1;
    case ROLE_MANAGER      = 2;
    case ROLE_SUPER_ADMIN  = 3;

    public static function getChoices(): array
    {
        return[
            self::ROLE_USER->value        => self::ROLE_USER->name,
            self::ROLE_ADMIN->value       => self::ROLE_ADMIN->name,
            self::ROLE_MANAGER->value     => self::ROLE_MANAGER->name,
            self::ROLE_SUPER_ADMIN->value => self::ROLE_SUPER_ADMIN->name,
        ];
    }
}