<?php

declare(strict_types=1);

namespace App\Service\Factory\Trello;

use App\Entity\Trello\Member;

class MemberFactory
{
    public static function createMember(
        string $id,
        string $avatarHash,
        string $avatarUrl,
    ): Member {
        $member = new Member();
        $member->setAvatarHash($avatarHash);
        $member->setAvatarUrl($avatarUrl);
        $member->setId($id);

        return $member;
    }
}
