<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Sprint;
use App\Entity\SprintUser;
use App\Entity\Trello\Card;
use App\Entity\User;
use App\Repository\SprintUserRepository;
use App\Repository\Trello\BoardListRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SprintUserExtension extends AbstractExtension
{
    public function __construct(
        private readonly SprintUserRepository $repository,
        private readonly BoardListRepository $boardListRepository,
    ) {
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('find_sprint_user', [$this, 'findSprintUserByUserAndSprint']),
            new TwigFunction('calculate_sp_sum_for_sprint', [$this, 'calculateSPSumForSprint']),
            new TwigFunction('calculate_sp_sum_for_sprint_user', [$this, 'calculateSPSumForSprintUser']),
            new TwigFunction('calculate_sp_sum_in_latest_done', [$this, 'calculateFinishedSPSumInLatestDone']),
        ];
    }

    public function findSprintUserByUserAndSprint(User $user, Sprint $sprint): ?SprintUser
    {
        return $this->repository->findSprintUserByUserAndSprint($user, $sprint);
    }

    public function calculateSPSumForSprintUser(SprintUser $sprintUser): float
    {
        $hours = $sprintUser->getAvailabilityInHours();
        $storyPoints = $hours / 4;

        return max($storyPoints, 0.25);
    }

    public function calculateSPSumForSprint(Sprint $sprint): float
    {
        $sumOfHours = $this->calculateSumOfHours($sprint);
        $storyPoints = $sumOfHours / 4;

        return max($storyPoints, 0.25);
    }

    public function calculateFinishedSPSumInLatestDone(): float
    {
        $doneList = $this->boardListRepository->findDoneList();
        $cards = $doneList->getCards();

        /* @var Card $card */
        return array_reduce($cards->toArray(), fn ($spSum, $card) => $spSum + $card->getStoryPoints(), 0);
    }

    private function calculateSumOfHours(Sprint $sprint): int
    {
        $sumOfHours = 0;

        /** @var SprintUser $sprintUser */
        foreach ($sprint->getSprintUsers() as $sprintUser) {
            $sumOfHours += $sprintUser->getAvailabilityInHours();
        }

        return (int) $sumOfHours;
    }
}
