<?php

namespace App\Controller\Admin;

use App\Entity\Meeting;
use App\Form\MeetingType;
use App\Repository\MeetingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/meeting', name: 'dev_')]
class MeetingController extends AbstractController
{
    #[Route('/', name: 'meeting_index', methods: ['GET'])]
    public function index(MeetingRepository $meetingRepository): Response
    {
        return $this->render('admin/meeting/index.html.twig', [
            'meetings' => $meetingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'meeting_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $meeting = new Meeting();
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($meeting);
            $entityManager->flush();

            return $this->redirectToRoute('dev_meeting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/meeting/new.html.twig', [
            'meeting' => $meeting,
            'form' => $form,
            ''
        ]);
    }

    #[Route('/{id}/edit', name: 'meeting_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Meeting $meeting, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('dev_meeting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/meeting/edit.html.twig', [
            'meeting' => $meeting,
            'form' => $form,
        ]);
    }
}
