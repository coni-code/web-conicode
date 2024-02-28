<?php

namespace App\Service\Factory;

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
