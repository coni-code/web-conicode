<?php

declare(strict_types=1);

namespace App\Controller\Website;

use App\Form\ContactType;
use App\Repository\UserRepository;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly MailerService $mailerService,
    ) {
    }

    #[Route('', name: 'app_home', methods: ['GET', 'POST'])]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->add('submit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->mailerService->sendContactUsData($form->getData(), $mailer);

            $this->addFlash('success', 'Siemano');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('website/home.html.twig', [
            'form' => $form,
            'users' => $this->userRepository->findAll(),
        ]);
    }
}
