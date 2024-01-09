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
        $user = UserFactory::createUser(
            $this->passwordHasher,
            'admin@admin.pl',
            'admin',
            ['ROLE_ADMIN'],
        );

        $this->addReference('user_admin', $user);

        $manager->persist($user);
        $manager->flush();
    }
}
