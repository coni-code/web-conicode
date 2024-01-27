<?php

declare(strict_types=1);

namespace App\Service\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public static function createUser(
        UserPasswordHasherInterface $passwordHasher,
        string $email,
        ?string $name,
        ?string $surname,
        string $password,
        array $roles,
    ): User {
        $user = new User();

        $user->setEmail($email);
        $user->setName($name);
        $user->setSurname($surname);
        $user->setPassword($passwordHasher->hashPassword($user, $password));
        $user->setRoles($roles);

        return $user;
    }
}
