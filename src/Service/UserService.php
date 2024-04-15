<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Enum\RoleEnum;
use App\Exception\NotFoundException;
use App\Repository\UserRepository;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{
    public function __construct(
        private readonly FilesystemOperator $uploadsCvStorage,
        private readonly LoggerInterface $logger,
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

    public function processForm(FormInterface $form, Request $request, User $user): void
    {
        /** @var User $editedUser */
        $editedUser = $form->getData();

        if ($form['password']->getData() != $user->getPassword()) {
            $editedUser->setPassword($this->passwordHasher->hashPassword($editedUser, $editedUser->getPassword()));
        }

        if ($form['cvFilename']) {
            $editedUser->setCvFilename($this->uploadCv($request, $user));
        }

        $this->userRepository->save($editedUser);
    }

    public function uploadCv(Request $request, User $user): ?string
    {
        $cvFile = $request->files->get('user')['cvFilename'];

        if (!$cvFile instanceof UploadedFile) {
            return null;
        }

        $newFilename = uniqid() . '.' . $cvFile->getClientOriginalExtension();

        if (!empty($user->getCvFilename())) {
            try {
                if ($this->uploadsCvStorage->fileExists($user->getCvFilename())) {
                    $this->uploadsCvStorage->delete($user->getCvFilename());
                }
            } catch (FilesystemException $e) {
                $this->logger->error('Error deleting old CV file: ' . $e->getMessage());
            }
        }

        $stream = fopen($cvFile->getRealPath(), 'r+');

        try {
            $this->uploadsCvStorage->writeStream($newFilename, $stream);
        } catch (FilesystemException $e) {
            $this->logger->error($e->getMessage());

            return null;
        }

        return $newFilename;
    }

    public function delete(string $id): bool
    {
        if (!$sprint = $this->userRepository->find($id)) {
            throw new NotFoundException();
        }

        return $this->userRepository->delete($sprint);
    }
}
