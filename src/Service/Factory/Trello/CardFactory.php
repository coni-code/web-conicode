<?php

declare(strict_types=1);

namespace App\Service\Factory\Trello;

use App\Entity\Trello\Card;

class CardFactory
{
    public static function createCard(
        string $id,
        string $name,
        string $description,
        string $url
    ): Card
    {
        $card = new Card();
        $card->setId($id);
        $card->setName($name);
        $card->setDescription($description);
        $card->setUrl($url);

        return $card;
    }
}
