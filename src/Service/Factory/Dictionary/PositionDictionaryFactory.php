<?php

declare(strict_types=1);

namespace App\Service\Factory\Dictionary;

use App\Entity\Dictionary\PositionDictionary;

class PositionDictionaryFactory
{
    public static function createPositionDictionary(
        string $name,
    ): PositionDictionary {
        $position = new PositionDictionary();

        $position->setName($name);

        return $position;
    }
}
