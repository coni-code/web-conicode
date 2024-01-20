<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\User;
use App\Service\UserService;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    public function __construct(
        private readonly UserService $userService,
    ) {
    }

    /**
     * @param User $subject
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, ['VIEW', 'EDIT'], true) && $subject instanceof User;
    }

    /**
     * @param User $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user) {
            return false;
        }
        if ($this->userService->isAdmin($user)) {
            return true;
        }
        if ($subject == $user) {
            return true;
        }

        return false;
    }
}
