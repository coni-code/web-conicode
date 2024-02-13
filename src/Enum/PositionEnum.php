<?php

declare(strict_types=1);

namespace App\Enum;

enum PositionEnum: string
{
    case LEAD_BACKEND_DEVELOPER = 'Lead Backend Developer';
    case JUNIOR_BACKEND_DEVELOPER = 'Junior Backend Developer';
    case ENTRY_BACKEND_DEVELOPER = 'Entry Backend Developer';
    case JUNIOR_FRONTEND_DEVELOPER = 'Junior Frontend Developer';
    case ENTRY_FRONTEND_DEVELOPER = 'Entry Frontend Developer';
    case INTERN_DEVELOPER = 'Intern Developer';
    case TEAM_LEADER = 'Team Leader';
    case PROJECT_MANAGER = 'Project Manager';
    case BUSINESS_ANALYST = 'Business Analyst';
    case GRAPHIC_DESIGNER = 'Graphic Designer';
    case HR = 'HR';
    case TRAINEE = 'Trainee';

    public static function getChoices(): array
    {
        return [
            self::LEAD_BACKEND_DEVELOPER->value => self::LEAD_BACKEND_DEVELOPER,
            self::JUNIOR_BACKEND_DEVELOPER->value => self::JUNIOR_BACKEND_DEVELOPER,
            self::ENTRY_BACKEND_DEVELOPER->value => self::ENTRY_BACKEND_DEVELOPER,
            self::JUNIOR_FRONTEND_DEVELOPER->value => self::JUNIOR_FRONTEND_DEVELOPER,
            self::ENTRY_FRONTEND_DEVELOPER->value => self::ENTRY_FRONTEND_DEVELOPER,
            self::INTERN_DEVELOPER->value => self::INTERN_DEVELOPER,
            self::TEAM_LEADER->value => self::TEAM_LEADER,
            self::PROJECT_MANAGER->value => self::PROJECT_MANAGER,
            self::BUSINESS_ANALYST->value => self::BUSINESS_ANALYST,
            self::GRAPHIC_DESIGNER->value => self::GRAPHIC_DESIGNER,
            self::HR->value => self::HR,
            self::TRAINEE->value => self::TRAINEE,
        ];
    }
}
