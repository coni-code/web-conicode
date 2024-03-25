<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
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
        $password = $user->getPassword();

        $form = $this->createForm(UserType::class, $user, ['isAdmin' => $isAdmin, 'password' => $password]);

        $form->add('submit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->handleForm($form, $password);

            return $this->redirectToRoute('dev_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
