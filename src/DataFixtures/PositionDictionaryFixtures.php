<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Service\Factory\PositionDictionaryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PositionDictionaryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $backend = $this->getReference('user_super_admin', User::class);
        $frontend = $this->getReference('user_admin', User::class);
        $pm = $this->getReference('user', User::class);

        $backendDev = PositionDictionaryFactory::createPositionDictionary(
            "Backend Developer",
        );
        $backendDev->addUser($backend);

        $frontendDev = PositionDictionaryFactory::createPositionDictionary(
            "Frontend Developer",
        );
        $frontendDev->addUser($frontend);

        $projectManager = PositionDictionaryFactory::createPositionDictionary(
            "Project Manager",
        );
        $projectManager->addUser($pm);

        $HR = PositionDictionaryFactory::createPositionDictionary(
            "Human Resources",
        );

        $HR->addUser($backend);
        $HR->addUser($frontend);
        $HR->addUser($pm);

        $manager->persist($backendDev);
        $manager->persist($frontendDev);
        $manager->persist($projectManager);
        $manager->persist($HR);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
