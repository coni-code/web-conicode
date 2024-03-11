<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\MeetingStatusEnum;
use App\Service\Factory\MeetingFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MeetingFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $startDay = new \DateTime('first day of this month');

        $user = $this->getReference('user_admin');
        if (!$user instanceof User) {
            throw new \RuntimeException(sprintf('Invalid %s reference', 'user_admin'));
        }

        for ($i = 0; $i < 10; ++$i) {
            $endDay = new \DateTime($startDay->format('Y-m-d'));
            $startDay = new \DateTime($startDay->format('Y-m-d'));
            $offset = $faker->numberBetween(1, 3);
            $startDay->add(\DateInterval::createFromDateString($offset . ' days'));
            $offset += $faker->numberBetween(0, 3);
            $endDay->add(\DateInterval::createFromDateString($offset . ' days'));

            $randomEvent = $faker->randomElement(['Coding', 'Brainstorming', 'Marketing', 'Retrospective', 'Planning']);
            $meeting = MeetingFactory::createMeeting(
                sprintf('Meeting: %s #%s', $randomEvent, $faker->numberBetween(1, 50)),
                $faker->realTextBetween(),
                $startDay,
                $endDay,
                $faker->randomElement([MeetingStatusEnum::STATUS_PENDING, MeetingStatusEnum::STATUS_CONFIRMED]),
            );

            $meeting->addUser($user);
            $manager->persist($meeting);
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
