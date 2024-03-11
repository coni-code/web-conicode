<?php

declare(strict_types=1);

namespace App\Form\DataTransformers;

use App\Enum\LinkTypeEnum;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use ValueError;

class LinkTypeTransformer implements DataTransformerInterface
{
    public function transform($value): string
    {
        if (null === $value) {
            return '';
        }

        if (!$value instanceof LinkTypeEnum) {
            throw new TransformationFailedException('Expected a LinkTypeEnum.');
        }

        return $value->value;
    }

    public function reverseTransform($value): ?LinkTypeEnum
    {
        if (!$value) {
            return null;
        }

        try {
            return LinkTypeEnum::from($value);
        } catch (ValueError $e) {
            throw new TransformationFailedException(
                sprintf(
                    'The value "%s" is not a valid LinkTypeEnum.',
                    $value
                ), 0, $e);
        }
    }
}
