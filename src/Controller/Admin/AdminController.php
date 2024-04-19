<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Repository\SprintRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(
        private readonly SprintRepository $sprintRepository,
    ){
    }

    #[Route('/admin', name: 'dev_admin')]
    public function index(): Response
    {
        $latestSprint = $this->sprintRepository->findLatestSprint();

        return $this->render('admin/dashboard/index.html.twig',
        [
            'latest_sprint' => $latestSprint,
        ]);
    }
}
