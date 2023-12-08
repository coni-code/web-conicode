<?php

namespace App\Service\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public static function createUser(
        UserPasswordHasherInterface $passwordHasher,
        string $email,
        string $password,
        array $roles
    ): User {
        $user = new User();

        $user->setEmail($email);
        $user->setPassword($passwordHasher->hashPassword($user, $password));
        $user->setRoles($roles);

        return $user;
    }
}
