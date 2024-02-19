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
        ?array $positions = null,
        ?string $githubLink = null,
        ?string $gitlabLink = null,
        ?string $linkedinLink = null,
        ?string $websiteLink = null,
        ?string $youtubeLink = null,
    ): User {
        $user = new User();

        $user->setEmail($email);
        $user->setName($name);
        $user->setSurname($surname);
        $user->setPassword($passwordHasher->hashPassword($user, $password));
        $user->setRoles($roles);
        $user->setPositions($positions);
        $user->setGithubLink($githubLink);
        $user->setGitlabLink($gitlabLink);
        $user->setYoutubeLink($youtubeLink);
        $user->setWebsiteLink($websiteLink);
        $user->setlinkedinLink($linkedinLink);

        return $user;
    }
}
