<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Meeting;
use App\Entity\User;
use App\Repository\MeetingRepository;
use App\Service\MeetingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/meeting', name: 'dev_')]
class MeetingController extends AbstractController
{
    public function __construct(
        private readonly MeetingRepository $meetingRepository,
        private readonly MeetingService $service,
    ) {
    }

    #[Route('/', name: 'meeting_index', methods: ['GET'])]
    public function index(MeetingRepository $meetingRepository): Response
    {
        $closestMeeting = null;
        $user = $this->getUser();
        if ($user instanceof User) {
            $closestMeeting = $this->meetingRepository->findClosestMeetingForUser($user);
        }

        return $this->render('admin/meeting/index.html.twig', [
            'meetings' => $meetingRepository->findAll(),
            'closest_meeting' => $closestMeeting,
        ]);
    }

    #[Route('/{id}/toggle-user', methods: ['POST'])]
    public function toggleUser(Meeting $meeting): JsonResponse
    {
        $user = $this->getUser();
        if ($user instanceof User) {
            $this->service->toggleUser($user, $meeting);

            return new JsonResponse(['status' => 'success'], Response::HTTP_OK);
        }

        return new JsonResponse(['status' => 'error'], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/{id}/update-users', methods: ['POST', 'GET'])]
    public function updateUsers(Meeting $meeting, Request $request): JsonResponse
    {
        $this->service->updateUsers($meeting, $request);

        return new JsonResponse(['status' => 'success'], Response::HTTP_OK);
    }
}
