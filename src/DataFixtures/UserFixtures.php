<?php

namespace App\DataFixtures;

use App\Service\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = UserFactory::createUser(
            'admin@admin.pl',
            password_hash('admin', PASSWORD_DEFAULT),
            ['ROLE_ADMIN'],
        );

        $manager->persist($user);
        $manager->flush();
    }
}
