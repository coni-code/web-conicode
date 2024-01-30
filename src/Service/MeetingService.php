<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Meeting;
use App\Entity\User;
use App\Enum\MeetingStatusEnum;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class MeetingService
{
    public const ASSIGNED_FOR_CONFIRMED_STATUS = 2;

    public function __construct(
        private readonly ManagerRegistry $doctrine,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function toggleUser(User $user, Meeting $meeting): void
    {
        if ($meeting->getUsers()->contains($user)) {
            $meeting->removeUser($user);
        } else {
            $meeting->addUser($user);
        }
        $this->handleStatus($meeting);
        $em = $this->doctrine->getManager();
        $em->persist($meeting);
        $em->flush();
    }

    public function updateUsers(Meeting $meeting, Request $request): void
    {
        $data = json_decode($request->getContent(), true);
        $userIds = $data['userIds'] ?? [];

        /** @var User $user */
        foreach ($meeting->getUsers()->toArray() as $user) {
            $user->removeMeeting($meeting);
        }

        foreach ($userIds as $userId) {
            $user = $this->userRepository->findOneBy(['id' => $userId]);
            if ($user) {
                $meeting->addUser($user);
            }
        }

        $this->handleStatus($meeting);

        $em = $this->doctrine->getManager();
        $em->persist($meeting);
        $em->flush();
    }

    private function handleStatus(Meeting $meeting): void
    {
        if (self::ASSIGNED_FOR_CONFIRMED_STATUS <= $meeting->getUsers()->count()) {
            $meeting->setStatus(MeetingStatusEnum::STATUS_CONFIRMED);
        } else {
            $meeting->setStatus(MeetingStatusEnum::STATUS_PENDING);
        }
    }
}
