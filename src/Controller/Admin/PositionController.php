<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Dictionary\PositionDictionary;
use App\Exception\NotFoundException;
use App\Form\Dictionary\PositionDictionaryType;
use App\Repository\PositionDictionaryRepository;
use App\Service\PositionDictionaryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/position', name: 'dev_position_')]
class PositionController extends AbstractController
{
    public function __construct(private readonly PositionDictionaryService $service)
    {
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(PositionDictionaryRepository $positionDictionaryRepository): Response
    {
        return $this->render('admin/dictionary/position/index.html.twig', [
            'positions' => $positionDictionaryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $position = new PositionDictionary();
        $form = $this->createForm(PositionDictionaryType::class, $position);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->save($position);

            return $this->redirectToRoute('dev_position_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/dictionary/position/new.html.twig', [
            'position' => $position,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PositionDictionary $position): Response
    {
        $form = $this->createForm(PositionDictionaryType::class, $position);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->save($position);

            return $this->redirectToRoute('dev_position_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/dictionary/position/edit.html.twig', [
            'position' => $position,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
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
