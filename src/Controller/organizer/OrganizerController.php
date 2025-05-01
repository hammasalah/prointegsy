<?php

namespace App\Controller\organizer;

use App\Entity\Users;
use App\Repository\JobsRepository;
use App\Repository\EventsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrganizerController extends AbstractController
{
    public function __construct(
        private JobsRepository $jobsRepository,
        private EventsRepository $eventsRepository,
        private UsersRepository $usersRepository
    ) {}

    #[Route('/organizer', name: 'app_organizer')]
    public function index(SessionInterface $session): Response
    {
        $user = $session->get('user');
    
        if (!$user) {
            throw $this->createNotFoundException('User not found in session');
        }
    
        return $this->render('organizer/organizer.html.twig', [
            'jobs' => $this->jobsRepository->findByUser($user),
            'events' => $this->eventsRepository->findByOrganizer($user),
            'user' => $user
        ]);
    }
}