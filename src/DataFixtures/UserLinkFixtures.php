<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\LinkTypeEnum;
use App\Service\Factory\UserLinkFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;

class UserLinkFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $userArray = [
            'user_super_admin',
            'user_admin',
            'user_manager',
            'user',
        ];

        $users = array_map(fn ($userReference) => $this->getReference($userReference), $userArray);

        foreach ($users as $user) {
            $this->loadForUser($user, $manager);
        }

        $manager->flush();
    }

    private function loadForUser(User $user, ObjectManager $manager): void
    {
        $links = [
            ['type' => LinkTypeEnum::GITHUB, 'url' => 'https://github.com/'],
            ['type' => LinkTypeEnum::GITLAB, 'url' => 'https://gitlab.com/'],
            ['type' => LinkTypeEnum::YOUTUBE, 'url' => 'https://youtube.com/'],
        ];

        foreach ($links as $link) {
            $userLink = UserLinkFactory::createUserLink($link['type'], $link['url']);
            $userLink->setUser($user);
            $manager->persist($userLink);
        }
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
