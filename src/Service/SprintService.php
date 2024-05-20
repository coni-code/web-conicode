<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Sprint;
use App\Entity\SprintUser;
use App\Entity\User;
use App\Exception\NotFoundException;
use App\Repository\SprintRepository;
use App\Repository\SprintUserRepository;
use Symfony\Component\Form\FormInterface;

class SprintService
{
    public function __construct(
        private readonly SprintRepository $sprintRepository,
        private readonly SprintUserRepository $sprintUserRepository,
    ) {
    }

    public function prepareSprintUser(Sprint $sprint, User $user): SprintUser
    {
        $sprintUser = $sprint->getSprintUsers()->filter(function(SprintUser $su) use ($user) {
            return $su->getUser() === $user;
        })->first() ?: new SprintUser();

        $sprintUser->setUser($user);
        $sprintUser->setSprint($sprint);

        return $sprintUser;
    }

    public function saveUserSprintDataFromForm(FormInterface $form): void
    {
        $this->sprintUserRepository->save($form->getData());
    }

    public function updateStoryPointSum(Sprint $sprint, float $storyPointSum): void
    {
        if ($storyPointSum <= 0) {
            $storyPointSum = 0;
        }

        $sprint->setStoryPoints($storyPointSum);
        $this->save($sprint);
    }

    public function save(Sprint $sprint): void
    {
        $this->sprintRepository->save($sprint);
    }

    public function delete(string $id): bool
    {
        if (!$sprint = $this->sprintRepository->find($id)) {
            throw new NotFoundException();
        }

        return $this->sprintRepository->delete($sprint);
    }
}
