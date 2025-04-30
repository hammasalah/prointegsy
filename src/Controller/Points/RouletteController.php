<?php

namespace App\Controller\Points;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RouletteController extends AbstractController
{
    #[Route('/points/fortune-wheel', name: 'points_fortune')]
    public function fortuneWheel(Request $request)
    {
        $date = new \DateTime($request->query->get('date')); // Récupère la date passée dans l'URL
        $isFirstDayOfMonth = $date->format('d') === '01'; // Vérifie si c'est le 1er jour du mois
    
        return $this->render('points/fortune-wheel.html.twig', [
            'isFirstDayOfMonth' => $isFirstDayOfMonth,
        ]);
    }
    

}
