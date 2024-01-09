<?php

declare(strict_types=1);

namespace App\DataFixtures\Trello;

use App\Service\Factory\Trello\OrganizationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class OrganizationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        $organization = OrganizationFactory::createOrganization(
            (string)$faker->numberBetween(100000,999999),
            $name = $faker->company(),
            $name,
            $faker->text(120),
            $faker->url()
        );
        $this->addReference('trello_organization', $organization);
        $manager->persist($organization);
        $manager->flush();
    }
}
