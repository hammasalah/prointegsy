<?php

namespace App\Controller\social;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SocialController extends AbstractController
{
    #[Route('/social', name: 'app_social')]
    public function index(): Response
    {
        return $this->render('social/social.html.twig', [
            'controller_name' => 'SocialController',
        ]);
    }
}
