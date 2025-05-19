<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PointsExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('format_points', [$this, 'formatPoints']),
        ];
    }

    /**
     * Filtre qui formate l'affichage des points de manière cohérente
     * 
     * @param mixed $points Les points à formater
     * @return string Les points formatés
     */
    public function formatPoints($points): string
    {
        // Assurer que les points sont un nombre
        $points = (int) $points;
        
        // Retourner les points formatés
        return number_format($points, 0, ',', ' ');
    }
}