<?php

namespace App\DataFixtures\Trello;

use App\Entity\Trello\Member;
use App\Entity\Trello\Organization;
use App\Service\Factory\Trello\BoardFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use RuntimeException;

class BoardFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        $organization = $this->getReference('trello_organization', Organization::class);

        if (!$organization instanceof Organization) {
            throw new RuntimeException("Invalid board reference");
        }
        $member = $this->getReference('trello_member', Member::class);

        if (!$member instanceof Member) {
            throw new RuntimeException("Invalid member reference");
        }
        $board = BoardFactory::createBoard(
            (string)$faker->numberBetween(10000,99999),
            $faker->company()
        );
        $board->setOrganization($organization);
        $board->addMember($member);
        $this->addReference('trello_board', $board);

        $manager->persist($board);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OrganizationFixtures::class,
            MemberFixtures::class
        ];
    }
}
