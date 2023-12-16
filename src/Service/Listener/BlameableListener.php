<?php

declare(strict_types=1);

namespace App\Service\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class BlameableListener implements EventSubscriber
{
    public function __construct(private readonly TokenStorageInterface $tokenStorage)
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (method_exists($entity, 'setCreatedBy')) {
            $entity->setCreatedBy($this->getCurrentUser());
        }
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (method_exists($entity, 'setUpdatedBy')) {
            $entity->setUpdatedBy($this->getCurrentUser());
        }
    }

    private function getCurrentUser(): ?UserInterface
    {
        return $this->tokenStorage->getToken()?->getUser();
    }
}
