<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Meeting;
use App\Entity\User;
use App\Form\MeetingType;
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
        private readonly MeetingService $service,
    ) {
    }

    #[Route('/', name: 'meeting_index', methods: ['GET'])]
    public function index(MeetingRepository $meetingRepository): Response
    {
        return $this->render('admin/meeting/index.html.twig', [
            'meetings' => $meetingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'meeting_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $meeting = new Meeting();
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Meeting $meeting */
            $meeting = $form->getData();
            $this->service->handleFormData($meeting);

            return $this->redirectToRoute('dev_meeting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/meeting/new.html.twig', [
            'meeting' => $meeting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'meeting_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Meeting $meeting): Response
    {
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Meeting $meeting */
            $meeting = $form->getData();
            $this->service->handleFormData($meeting);

            return $this->redirectToRoute('dev_meeting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/meeting/edit.html.twig', [
            'meeting' => $meeting,
            'form' => $form,
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
}
