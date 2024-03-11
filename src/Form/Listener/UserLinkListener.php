<?php

declare(strict_types=1);

namespace App\Form\Listener;

use App\Entity\User;
use App\Entity\UserLink;
use App\Enum\LinkTypeEnum;
use Symfony\Component\Form\FormEvent;

class UserLinkListener
{
    public function onPreSetData(FormEvent $event): void
    {
        $user = $event->getData();

        if (!$user instanceof User) {
            return;
        }

        $existingLinksMap = [];
        foreach ($user->getLinks() as $link) {
            $existingLinksMap[$link->getType()->value] = $link;
        }

        foreach (LinkTypeEnum::cases() as $linkType) {
            if (array_key_exists($linkType->value, $existingLinksMap)) {
                continue;
            } else {
                $userLink = new UserLink();
                $userLink->setType($linkType);
                $user->addLink($userLink);
            }
        }
    }
}
