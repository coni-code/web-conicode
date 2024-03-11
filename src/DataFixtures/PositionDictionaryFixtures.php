<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Service\Factory\Dictionary\PositionDictionaryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PositionDictionaryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = [
            'user_super_admin',
            'user_admin',
            'user_manager',
            'user',
        ];
        $positions = [
            PositionDictionaryFactory::createPositionDictionary('Backend Developer'),
            PositionDictionaryFactory::createPositionDictionary('Frontend Developer'),
            PositionDictionaryFactory::createPositionDictionary('Project Manager'),
            PositionDictionaryFactory::createPositionDictionary('Human Resources'),
        ];

        foreach ($users as $user) {
            $user = $this->getReference($user, User::class);
            if (!$user instanceof User) {
                continue;
            }

            if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
                foreach ($positions as $position) {
                    $user->addPosition($position);
                }

                $manager->persist($user);

                continue;
            }

            $user->addPosition($positions[rand(0, 3)]);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
