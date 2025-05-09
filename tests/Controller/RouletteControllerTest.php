<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;

class RouletteControllerTest extends WebTestCase
{
    // Tests commentés temporairement pour permettre l'utilisation de la roue à tout moment
    /*
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
    */

    

    public function testSpinRouletteAndEarnPoints()
    {
        // Créer un client pour tester la page
        $client = static::createClient();

        // Simuler un utilisateur connecté
        $user = new User();
        $user->setPoints(0);
        
        // Simuler une requête POST avec des points gagnés
        $client->request(
            'POST',
            '/points/fortune-wheel/spin',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['points' => 100])
        );

        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        
        $data = json_decode($response->getContent(), true);
        $this->assertTrue($data['success']);
        $this->assertEquals(100, $data['points']);
        $this->assertEquals(100, $data['totalPoints']);
    }
}
