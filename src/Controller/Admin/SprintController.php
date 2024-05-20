<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Sprint;
use App\Entity\User;
use App\Exception\NotFoundException;
use App\Form\SprintType;
use App\Form\UserSprintType;
use App\Repository\SprintRepository;
use App\Repository\UserRepository;
use App\Service\SprintService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sprint', name: 'dev_')]
class SprintController extends AbstractController
{
    public function __construct(
        private readonly SprintService $service,
        private readonly UserRepository $userRepository,
    ) {
    }

    #[Route('/', name: 'sprint_index', methods: ['GET'])]
    public function index(SprintRepository $sprintRepository): Response
    {
        return $this->render('admin/sprint/index.html.twig', [
            'sprints' => $sprintRepository->findAllOrderedByStartDate(),
        ]);
    }

    #[Route('/new', name: 'sprint_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $sprint = new Sprint();
        $form = $this->createForm(SprintType::class, $sprint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->save($sprint);

            return $this->redirectToRoute('dev_sprint_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/sprint/new.html.twig', [
            'sprint' => $sprint,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'sprint_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sprint $sprint): Response
    {
        $form = $this->createForm(SprintType::class, $sprint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->save($sprint);

            return $this->redirectToRoute('dev_sprint_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/sprint/edit.html.twig', [
            'sprint' => $sprint,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/details', name: 'sprint_details', methods: ['GET', 'POST'])]
    public function details(Request $request, Sprint $sprint): Response
    {
        $user = $this->getUser();
        $sprintUser = null;

        if ($user instanceof User) {
            $sprintUser = $this->service->prepareSprintUser($sprint, $user);
        }

        $form = $this->createForm(UserSprintType::class, $sprintUser);
        $form->add('submit', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->saveUserSprintDataFromForm($form);

            return $this->redirectToRoute('dev_sprint_details', ['id' => $sprint->getId()]);
        }

        return $this->render('admin/sprint/details.html.twig', [
            'sprint' => $sprint,
            'users' => $this->userRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'sprint_delete', methods: ['POST'])]
    public function delete(Request $request, string $id): Response
    {
        try {
            $this->service->delete($id);
        } catch (NotFoundException $e) {
            return new Response('error', Response::HTTP_NOT_FOUND);
        }

        return new Response('success', Response::HTTP_OK);
    }
}
