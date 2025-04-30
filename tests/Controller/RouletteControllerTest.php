<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouletteControllerTest extends WebTestCase
{
    public function testRouletteCanOnlyBeUsedOnFirstDay()
    {
        // Créer un client pour tester la page
        $client = static::createClient();

        // Simuler la date du 1er mai 2025 dans l'URL
        // Remarque : on ajoute la date à l'URL comme paramètre de la requête
        $crawler = $client->request('GET', '/points/fortune-wheel?date=2025-05-01');

        // Vérifier si le paramètre 'isFirstDayOfMonth' est correct
        $this->assertSelectorTextContains('body', 'true'); // Si c'est le 1er du mois, 'isFirstDayOfMonth' doit être vrai
    }

    public function testRouletteCannotBeUsedOnNonFirstDay()
    {
        // Créer un client pour tester la page
        $client = static::createClient();

        // Simuler une date différente du 1er mai 2025 (par exemple, le 2 mai 2025)
        $crawler = $client->request('GET', '/points/fortune-wheel?date=2025-05-02');

        // Vérifier si le paramètre 'isFirstDayOfMonth' est correct
        $this->assertSelectorTextContains('body', 'false'); // Si ce n'est pas le 1er du mois, 'isFirstDayOfMonth' doit être faux
    }

    

    
    
    
}
