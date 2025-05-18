<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RootController extends AbstractController
{
    #[Route('', name: 'app_root')]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/points', name: 'app_points')]
    public function points(): Response
    {
        return $this->render('points/index.html.twig');
    }

    #[Route('/points/convert', name: 'app_convert_points')]
    public function convertPoints(): Response
    {
        return $this->render('points/convert.html.twig');
    }

    // La route fortune-wheel est maintenant gérée exclusivement par RouletteController
}