<?php

declare(strict_types=1);

namespace App\Service\Listener;

use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use ReflectionClass;

class TimestampableListener implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->updateTimestamps($args, 'setCreatedAt');
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->updateTimestamps($args, 'setUpdatedAt');
    }

    private function updateTimestamps(LifecycleEventArgs $args, string $methodName): void
    {
        $entity = $args->getObject();
        $reflectionClass = new ReflectionClass($entity);

        if ($reflectionClass->hasMethod($methodName)) {
            $method = $reflectionClass->getMethod($methodName);
            $method->invoke($entity, new DateTime('now'));
        }
    }
}
