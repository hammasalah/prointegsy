<?php

namespace App\Controller\Points;

use App\Entity\Users;
use App\Repository\HistoriquePointsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RouletteController extends AbstractController
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
    public function fortuneWheel(EntityManagerInterface $entityManager, HistoriquePointsRepository $historiqueRepo): Response
    {
        $user = $entityManager->getRepository(Users::class)->find(1);
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur avec l\'ID 1 non trouvé. Veuillez créer cet utilisateur en base.');
        }

        $historique = $historiqueRepo->findRecentByUser($user) ?: [];

        return $this->render('points/fortune_wheel.html.twig', [
            'user' => $user,
            'historique' => $historique
        ]);
    }


}