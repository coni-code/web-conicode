<?php

declare(strict_types=1);

namespace App\DataFixtures\Trello;

use App\Entity\Trello\BoardList;
use App\Entity\Trello\Member;
use App\Service\Factory\Trello\CardFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use RuntimeException;

class CardFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        $lists = ['sprint_backlog', 'in_progress', 'qa_waiting', 'review', 'done'];
        $member = $this->getReference('trello_member', Member::class);

        if (!$member instanceof Member) {
            throw new RuntimeException("Invalid member reference");
        }

        $cardCount = 1;
        foreach ($lists as $list) {
            $boardList = $this->getReference($list, BoardList::class);

            if (!$boardList instanceof BoardList) {
                throw new RuntimeException("Invalid list reference");
            }

            for ($i = 1; $i <= 10; $i++) {
                $card = CardFactory::createCard(
                    (string)$faker->numberBetween(10000,99999),
                    'Card - ' . $cardCount, $faker->realText(),
                    $faker->url());
                $faker->randomElement([0, 1]) ?: $card->addMember($member);
                $card->setBoardList($boardList);
                $manager->persist($card);
                $cardCount++;
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BoardListFixtures::class,
            MemberFixtures::class
        ];
    }
}
