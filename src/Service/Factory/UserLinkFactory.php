<?php

declare(strict_types=1);

namespace App\Service\Factory;

use App\Entity\UserLink;
use App\Enum\LinkTypeEnum;

class UserLinkFactory
{
    public static function createUserLink(
        LinkTypeEnum $type,
        string $url,
    ): UserLink {
        $userLink = new UserLink();

        $userLink->setType($type);
        $userLink->setUrl($url);

        return $userLink;
    }
}
