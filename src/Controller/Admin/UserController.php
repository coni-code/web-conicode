<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Exception\NotFoundException;
use App\Form\UserType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user', name: 'dev_')]
class UserController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
    ) {
    }

    #[Route('/{id}/edit', name: 'user_edit')]
    public function edit(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('VIEW', $user);

        $isAdmin = $this->userService->isAdmin($this->getUser());
        $form = $this->createForm(UserType::class, $user, [
            'isAdmin' => $isAdmin,
            'password' => $user->getPassword(),
        ]);

        $form->add('submit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->processForm($form, $request, $user);

            return $this->redirectToRoute('dev_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, string $id): Response
    {
        try {
            $this->userService->delete($id);
        } catch (NotFoundException $e) {
            return new Response('error', Response::HTTP_NOT_FOUND);
        }

        return new Response('success', Response::HTTP_OK);
    }
}
