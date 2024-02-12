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
            self::LEAD_BACKEND_DEVELOPER->name => self::LEAD_BACKEND_DEVELOPER->value,
            self::JUNIOR_BACKEND_DEVELOPER->name => self::JUNIOR_BACKEND_DEVELOPER->value,
            self::ENTRY_BACKEND_DEVELOPER->name => self::ENTRY_BACKEND_DEVELOPER->value,
            self::JUNIOR_FRONTEND_DEVELOPER->name => self::JUNIOR_FRONTEND_DEVELOPER->value,
            self::ENTRY_FRONTEND_DEVELOPER->name => self::ENTRY_FRONTEND_DEVELOPER->value,
            self::INTERN_DEVELOPER->name => self::INTERN_DEVELOPER->value,
            self::TEAM_LEADER->name => self::TEAM_LEADER->value,
            self::PROJECT_MANAGER->name => self::PROJECT_MANAGER->value,
            self::BUSINESS_ANALYST->name => self::BUSINESS_ANALYST->value,
            self::GRAPHIC_DESIGNER->name => self::GRAPHIC_DESIGNER->value,
            self::HR->name => self::HR->value,
            self::TRAINEE->name => self::TRAINEE->value,
        ];
    }
}
