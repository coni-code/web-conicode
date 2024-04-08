<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Enum\RoleEnum;
use App\Exception\NotFoundException;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function isAdmin(UserInterface $user): bool
    {
        if (!$user instanceof User) {
            return false;
        }

        return in_array(RoleEnum::ROLE_ADMIN->name, $user->getRoles(), true);
    }

    public function handleForm(FormInterface $form, string $password): void
    {
        /** @var User $user */
        $user = $form->getData();

        if ($form['password']->getData() != $password) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
        }

        $this->userRepository->save($user);
    }

    public function delete(string $id): bool
    {
        if (!$sprint = $this->userRepository->find($id)) {
            throw new NotFoundException();
        }

        return $this->userRepository->delete($sprint);
    }
}
