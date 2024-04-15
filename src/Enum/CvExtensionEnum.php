<?php

declare(strict_types=1);

namespace App\Enum;

enum CvExtensionEnum: string
{
    case DOC  = 'doc';
    case DOCX = 'docx';
    case PDF  = 'pdf';

    public static function getChoices(): array
    {
        return [
            self::DOC->value => self::DOC->name,
            self::DOCX->value => self::DOCX->name,
            self::PDF->value => self::PDF->name,
        ];
    }
}
