<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('min', [$this, 'minFilter']),
        ];
    }

    /**
     * Filtre qui retourne la valeur minimale entre la valeur donnée et une limite
     */
    public function minFilter($value, $limit): float
    {
        return min((float) $value, (float) $limit);
    }
}