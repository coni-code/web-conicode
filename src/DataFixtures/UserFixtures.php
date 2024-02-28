<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Enum\PositionEnum;
use App\Service\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $superAdmin = UserFactory::createUser(
            $this->passwordHasher,
            'super@admin.pl',
            $faker->name(),
            $faker->lastName(),
            'admin',
            ['ROLE_ADMIN'],
            $faker->imageUrl(),
            $faker->imageUrl(),
            $faker->imageUrl(),
            $faker->imageUrl(),
            null,
        );

        $admin = UserFactory::createUser(
            $this->passwordHasher,
            'admin@admin.pl',
            $faker->name(),
            $faker->lastName(),
            'admin',
            ['ROLE_ADMIN'],
            $faker->imageUrl(),
            null,
            $faker->imageUrl(),
        );

        $pm = UserFactory::createUser(
            $this->passwordHasher,
            'manager@manager.pl',
            $faker->name(),
            $faker->lastName(),
            'manager',
            ['ROLE_MANAGER'],
            null,
            null,
            $faker->imageUrl(),
            $faker->imageUrl(),
            $faker->imageUrl(),
        );

        $user = UserFactory::createUser(
            $this->passwordHasher,
            'user@user.pl',
            $faker->name(),
            $faker->lastName(),
            'user',
            ['ROLE_USER'],
            $faker->imageUrl(),
            null,
            $faker->imageUrl(),
            $faker->imageUrl(),
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
