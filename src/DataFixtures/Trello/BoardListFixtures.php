<?php

namespace App\DataFixtures\Trello;

use App\Entity\Trello\Board;
use App\Service\Factory\Trello\BoardListFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use RuntimeException;

class BoardListFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        $lists = ['Sprint Backlog', 'In Progress', 'QA Waiting', 'Review', 'Done'];

        $board = $this->getReference('trello_board', Board::class);

        if (!$board instanceof Board) {
            throw new RuntimeException("Invalid board reference");
        }

        foreach ($lists as $list) {
            $boardList = BoardListFactory::createBoardList(
                $faker->numberBetween(10000,99999),
                $list,true);
            $manager->persist($boardList);
            $this->addReference(str_replace(' ', '_', strtolower($list)), $boardList);
            $boardList->setBoard($board);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BoardFixtures::class
        ];
    }
}
