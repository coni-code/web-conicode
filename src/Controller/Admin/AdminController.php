<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\SprintRepository;
use App\Repository\SprintUserRepository;
use App\Repository\Trello\CardRepository;
use App\Trello\Client\Config;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(
        private readonly SprintRepository $sprintRepository,
        private readonly SprintUserRepository $sprintUserRepository,
        private readonly CardRepository $cardRepository,
        private readonly Config $config,
    ) {
    }

    #[Route('/admin', name: 'dev_admin')]
    public function index(): Response
    {
        $user = $this->getUser();
        $latestSprint = $this->sprintRepository->findLatestSprint();
        $boardId = $this->config->getBoardId();
        $sprintUser = null;
        $toDoCards = null;

        if ($user instanceof User && $latestSprint) {
            $sprintUser = $this->sprintUserRepository->findSprintUserByUserAndSprint($user, $latestSprint);
            $toDoCards = $this->cardRepository->findToDoCardsAssignedToUser($user, $boardId);
        }

        return $this->render('admin/dashboard/index.html.twig', [
            'latest_sprint' => $latestSprint,
            'sprint_user' => $sprintUser,
            'to_do_cards' => $toDoCards,
        ]);
    }
}
