<?php

namespace App\DataFixtures;

use App\Service\Factory\SprintFactory;
use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker;

class SprintFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        $startDay = new DateTime('first day of this month');

        for ($i = 1; $i < 11; $i++) {
            $endDay = new DateTime($startDay->format('Y-m-d'));
            $startDay = new DateTime($startDay->format('Y-m-d'));
            $offset = 7;
            $startDay->add(DateInterval::createFromDateString($offset . ' days'));
            $offset += 7;
            $endDay->add(DateInterval::createFromDateString($offset . ' days'));

            $sprint = SprintFactory::createSprint(
                "Sprint [$i]",
                $startDay,
                $endDay,
                $faker->numberBetween(4,24),
                $faker->randomElement([true, false]),
            );

            $manager->persist($sprint);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }
}
