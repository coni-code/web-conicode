<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Sprint;
use App\Entity\SprintUser;
use App\Entity\Trello\Card;
use App\Entity\User;
use App\Repository\SprintUserRepository;
use App\Repository\Trello\BoardListRepository;
use App\Service\SprintService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SprintUserExtension extends AbstractExtension
{
    public function __construct(
        private readonly SprintService $sprintService,
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
            new TwigFunction('calculate_sp_sum_for_sprint_user_in_latest_done', [$this, 'calculateFinishedSPSumForSprintUserInLatestDone']),
        ];
    }

    public function findSprintUserByUserAndSprint(User $user, Sprint $sprint): ?SprintUser
    {
        return $this->repository->findSprintUserByUserAndSprint($user, $sprint);
    }

    public function calculateSPSumForSprintUser(SprintUser $sprintUser): float
    {
        return $this->calculateSPSum($sprintUser->getAvailabilityInHours());
    }

    public function calculateSPSumForSprint(Sprint $sprint): float
    {
        $spSum = $this->calculateSPSum($this->calculateSumOfHours($sprint));
        $this->sprintService->updateStoryPointSum($sprint, $spSum);

        return $spSum;
    }

    public function calculateFinishedSPSumInLatestDone(): float
    {
        $doneList = $this->boardListRepository->findDoneList();
        if (!$doneList) {
            return 0;
        }

        $cards = $doneList->getCards();

        /* @var Card $card */
        return array_reduce($cards->toArray(), fn ($spSum, $card) => $spSum + $card->getStoryPoints(), 0);
    }

    public function calculateFinishedSPSumForSprintUserInLatestDone(SprintUser $sprintUser): float
    {
        $doneList = $this->boardListRepository->findDoneList();
        if (!$doneList) {
            return 0;
        }

        $member = $sprintUser->getUser()->getMember();
        $allCards = $doneList->getCards();

        $totalSP = 0;
        foreach ($allCards as $card) {
            if (in_array($member, $card->getMembers()->toArray(), true)) {
                $numberOfMembers = count($card->getMembers());
                if ($numberOfMembers > 0) {
                    $spPerMember = $card->getStoryPoints() / $numberOfMembers;
                    $roundedSP = $this->roundToNearestQuarter($spPerMember);
                    $totalSP += $roundedSP;
                }
            }
        }

        return $totalSP;
    }

    private function calculateSPSum(float $hours): float
    {
        $storyPoints = $hours / 4;

        if ($storyPoints <= 0) {
            return 0;
        }

        return max($storyPoints, 0.25);
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

    private function roundToNearestQuarter(float $number): float
    {
        if ($number <= 0 ) {
            return 0;
        }

        return round($number * 4) / 4;
    }
}
