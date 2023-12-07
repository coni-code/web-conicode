<?php

namespace App\Service\Factory;

use App\Entity\User;

class UserFactory
{
    public static function createUser(string $email, string $password, array $roles): User
    {
        $user = new User();

        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRoles($roles);

        return $user;
    }
}
