<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CaseExtension extends AbstractExtension
{
    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('lcFirst', [$this, 'lcFirst']),
        ];
    }

    /**
     * @param string $string
     * @return string
     */
    public function lcFirst(string $string): string
    {
        return lcfirst($string);
    }
}