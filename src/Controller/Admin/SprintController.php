<?php

namespace App\Controller\Admin;

use App\Entity\Sprint;
use App\Exception\NotFoundException;
use App\Form\SprintType;
use App\Repository\SprintRepository;
use App\Service\SprintService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sprint', name: 'dev_')]
class SprintController extends AbstractController
{
    public function __construct(private readonly SprintService $service)
    {
    }

    #[Route('/', name: 'sprint_index', methods: ['GET'])]
    public function index(SprintRepository $sprintRepository): Response
    {
        return $this->render('admin/sprint/index.html.twig', [
            'sprints' => $sprintRepository->findAll(),
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
            'form' => $form,
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
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'sprint_delete', methods: ['POST'])]
    public function delete(Request $request, string $id): Response
    {
        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            try {
                $this->service->delete($id);
            } catch (NotFoundException $e) {
            }
        }

        return $this->redirectToRoute('dev_sprint_index', [], Response::HTTP_SEE_OTHER);
    }
}
