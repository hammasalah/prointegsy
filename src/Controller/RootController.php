<?php
// src/Controller/RootController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// Retrait des use inutiles ici (EventsRepository, LoggerInterface)

class RootController extends AbstractController
{
    // Plus besoin de constructeur si pas de dépendances

    #[Route('', name: 'app-root')]
    public function index(): Response // Plus besoin d'injecter EventsRepository
    {
        // Rend simplement le template de base SANS passer de données spécifiques à la carte
        // Le contenu du block body sera celui par défaut de base.html.twig
        // ou celui que votre ami mettra dans un template dédié comme 'landing.html.twig'
        // qui étendrait 'base.html.twig'.
        // Si vous voulez une page complètement vide qui étend base:
        // return $this->render('root/empty_root.html.twig'); // et créez ce fichier vide qui étend base.
        // Pour l'instant, rendons juste la base.
        return $this->render('base.html.twig');
    }
}