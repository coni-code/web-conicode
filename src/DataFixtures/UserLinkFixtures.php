<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\MeetingStatusEnum;
use App\Service\Factory\MeetingFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker;

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

        $users = array_map(fn ($userReference) => $this->getReference($userReference, User::class), $userArray);

        foreach ($users as $user) {
            $this->loadForUser($user);
        }
    }

    private function loadForUser(User $user)
    {

    }

    private function preparePositionsForUser(User $user)
    {

    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
