<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Service\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $superAdmin = UserFactory::createUser(
            $this->passwordHasher,
            'super@admin.pl',
            'admin',
            ['ROLE_ADMIN'],
        );

        $admin = UserFactory::createUser(
            $this->passwordHasher,
            'admin@admin.pl',
            'admin',
            ['ROLE_ADMIN'],
        );

        $pm = UserFactory::createUser(
            $this->passwordHasher,
            'manager@manager.pl',
            'manager',
            ['ROLE_MANAGER'],
        );

        $user = UserFactory::createUser(
            $this->passwordHasher,
            'user@user.pl',
            'user',
            ['ROLE_USER'],
        );

        $this->addReference('user_super_admin', $superAdmin);
        $this->addReference('user_admin', $admin);
        $this->addReference('user_manager', $pm);
        $this->addReference('user', $user);

        $manager->persist($superAdmin);
        $manager->persist($admin);
        $manager->persist($pm);
        $manager->persist($user);
        $manager->flush();
    }
}
