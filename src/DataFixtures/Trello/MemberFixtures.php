<?php

declare(strict_types=1);

namespace App\DataFixtures\Trello;

use App\DataFixtures\UserFixtures;
use App\Entity\User;
use App\Service\Factory\Trello\MemberFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class MemberFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        $user = $this->getReference('user_admin');

        if (!$user instanceof User) {
            throw new \RuntimeException('Invalid user reference');
        }

        $member = MemberFactory::createMember(
            (string) $faker->numberBetween(10000, 99999),
            null,
            $faker->imageUrl(),
        );
        $this->addReference('trello_member', $member);
        $member->setUser($user);
        $manager->persist($member);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
