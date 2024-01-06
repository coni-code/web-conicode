<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LocaleExtension extends AbstractExtension
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_locale', [$this, 'getLocale']),
        ];
    }

    public function getLocale(): string
    {
        $request = $this->requestStack->getCurrentRequest();

        return $request ? $request->getLocale() : 'pl';
    }
}
