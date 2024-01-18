<?php

declare(strict_types=1);

namespace App\Service\Normalizer;

use App\Entity\Meeting;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MeetingNormalizer implements NormalizerInterface
{
    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof Meeting;
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        $avatarUrls = [];
        $trelloAvatarsPath = '/build/trello/avatar';
        $defaultAvatar = '/build/images/default/avatar.png';

        if (!$object instanceof Meeting) {
            return [];
        }

        foreach ($object->getUsers() as $user) {
            $avatarUrls[] = $user->getMember() && $user->getMember()->getAvatarHash() ? sprintf(
                '%s/%s.%s',
                $trelloAvatarsPath,
                $user->getMember()->getAvatarHash(),
                'png',
            ) : $defaultAvatar;
        }

        return [
            'id' => $object->getId(),
            'title' => $object->getTitle(),
            'startDate' => $object->getStartDate()->format('Y-m-d'),
            'endDate' => $object->getEndDate()->format('Y-m-d'),
            'status' => $object->getStatus(),
            'avatarUrl' => $avatarUrls,
        ];
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Meeting::class => true,
        ];
    }
}
