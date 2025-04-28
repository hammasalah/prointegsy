<?php

namespace App\Controller;

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

    #[Route('/points/fortune-wheel', name: 'app_fortune_wheel')]
    public function fortuneWheel(): Response
    {
        return $this->render('points/fortune_wheel.html.twig');
    }
}