<?php

declare(strict_types=1);

namespace App\Twig;

use App\Service\UserService;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UserExtension extends AbstractExtension
{
    public function __construct(
        private readonly UserService $userService,
    ) {
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_admin', [$this, 'isAdmin']),
        ];
    }

    public function isAdmin(UserInterface $user): bool
    {
        return $this->userService->isAdmin($user);
    }
}
