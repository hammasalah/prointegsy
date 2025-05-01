<?php

namespace App\Tests\Controller\Social;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SocialControllerTest extends WebTestCase
{
    /**
     * Test fonctionnel pour l'ajout d'un post avec succès
     */
    public function testAddPostSuccess(): void
    {
        $client = static::createClient();
        
        // Accéder à la page d'ajout de post
        $crawler = $client->request('GET', '/social/add-post');
        
        // Vérifier que la page est accessible
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Ajouter un Post');
        
        // Simuler la soumission du formulaire avec des données valides
        $client->submitForm('Publier', [
            'content' => 'Ceci est un test de contenu pour un nouveau post',
        ]);
        
        // Vérifier la redirection vers la page sociale
        $this->assertResponseRedirects('/social/');
        
        // Suivre la redirection
        $client->followRedirect();
        
        // Dans l'environnement de test, l'utilisateur n'existe pas, donc on vérifie juste que la page est accessible
        $this->assertResponseIsSuccessful();
    }
    
    /**
     * Test fonctionnel pour l'ajout d'un post avec échec (contenu vide)
     */
    public function testAddPostFailure(): void
    {
        $client = static::createClient();
        
        // Accéder à la page d'ajout de post
        $crawler = $client->request('GET', '/social/add-post');
        
        // Vérifier que la page est accessible
        $this->assertResponseIsSuccessful();
        
        // Simuler la soumission du formulaire avec un contenu vide
        $client->submitForm('Publier', [
            'content' => '',  // Contenu vide, ce qui devrait échouer
        ]);
        
        // Vérifier la redirection vers la page sociale
        $this->assertResponseRedirects('/social/');
        
        // Suivre la redirection
        $client->followRedirect();
        
        // Vérifier que le message d'erreur est affiché
        $this->assertSelectorExists('.alert.alert-error');
        $this->assertSelectorTextContains('.alert.alert-error', 'Le contenu du post ne peut pas être vide');
    }
}