<?php
// src/Controller/events/EventsController.php

namespace App\Controller\events;

use App\Entity\Events;
use App\Entity\Users;
use App\Entity\Category;
use App\Form\EventsType;
use App\Repository\EventsRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use Psr\Log\LoggerInterface;

class EventsController extends AbstractController
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    // --- Action INDEX : Affiche la LISTE des événements ---
    #[Route('/events', name: 'app_events', methods: ['GET'])]
    public function index(
        Request $request,
        EventsRepository $eventsRepository,
        CategoryRepository $categoryRepository
    ): Response {
        // Récupération des filtres/recherche depuis l'URL
        $searchTerm = $request->query->get('search');
        $categoryIdParam = $request->query->get('category');
        $categoryId = null;
        if (!empty($categoryIdParam) && ctype_digit((string)$categoryIdParam)) {
            $categoryId = (int)$categoryIdParam;
        }

        // Récupération des données filtrées et des catégories
        $events = [];
        $categories = [];
        try {
            $events = $eventsRepository->findByNameDescriptionCategory($searchTerm, $categoryId);
            $categories = $categoryRepository->findBy([], ['name' => 'ASC']);
        } catch (\Exception $e) {
            $this->logger->error('Error fetching events or categories for list: ' . $e->getMessage());
            $this->addFlash('error', 'An error occurred while retrieving event data.');
        }

        // Rend le template de la liste, en passant les événements et les catégories
        return $this->render('events/events.html.twig', [
            'events' => $events,
            'categories' => $categories,
            // PAS besoin de passer le formulaire d'ajout ici
        ]);
    }

    // --- Action ADD_PAGE : Affiche la PAGE avec le formulaire d'ajout VIERGE ---
    #[Route('/events/add', name: 'app_event_add_page', methods: ['GET'])]
    public function addEventPage(): Response
    {
        $event = new Events(); // Crée une instance d'événement vide
        // Crée le formulaire associé à cette instance vide
        $form = $this->createForm(EventsType::class, $event, [
             // On peut définir l'action ici, ou laisser form_start le faire dans Twig
             'action' => $this->generateUrl('app_event_new'),
             'method' => 'POST',
        ]);

        // Rend le template dédié à l'ajout, en passant la VUE du formulaire
        return $this->render('events/add_event.html.twig', [
            'create_event_form' => $form->createView(),
        ]);
    }

    // --- Action NEW : TRAITE la soumission POST venant de la page d'ajout ---
    #[Route('/events/new', name: 'app_event_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $event = new Events(); // Crée une nouvelle instance pour recevoir les données
        $form = $this->createForm(EventsType::class, $event); // Crée le formulaire
        $form->handleRequest($request); // Lie le formulaire aux données POST de la requête

        // Si le formulaire est soumis ET valide (contraintes respectées)
        if ($form->isSubmitted() && $form->isValid()) {
            $this->logger->info('Add event form submitted and VALID.');

            // --- Logique de traitement des données valides ---
            // (Exactement comme avant)
            $organizer = $em->getRepository(Users::class)->find(1); // TODO: User connecté
            if (!$organizer) {
                 $this->addFlash('error', 'Default organizer (User ID 1) not found.');
                 // En cas d'erreur critique, on redirige vers la liste (ou page erreur)
                 return $this->redirectToRoute('app_events');
            }
            $event->setOrganizerId($organizer);

            try { // Traitement des dates
                $startTimeData = $form->get('startTime')->getData(); $endTimeData = $form->get('endTime')->getData();
                if (!$startTimeData instanceof \DateTimeInterface || !$endTimeData instanceof \DateTimeInterface) throw new \InvalidArgumentException('Invalid date format.');
                $event->setStartTime($startTimeData->format('Y-m-d H:i:s')); $event->setEndTime($endTimeData->format('Y-m-d H:i:s'));
            } catch (\Exception $e) {
                $this->logger->error('Error processing dates on ADD page: ' . $e->getMessage());
                $this->addFlash('error', 'Error processing dates: ' . $e->getMessage());
                 // Ré-affiche la page d'ajout AVEC le formulaire et ses erreurs
                 return $this->render('events/add_event.html.twig', ['create_event_form' => $form->createView()]);
            }

            $imageFile = $form->get('image')->getData(); // Traitement image
            if ($imageFile instanceof UploadedFile) {
                 if ($imageFile->isValid()) {
                     try { $event->setImage(base64_encode(file_get_contents($imageFile->getPathname()))); }
                     catch (\Exception $e) {
                        $this->logger->error('Failed to process image on ADD page: ' . $e->getMessage());
                        $this->addFlash('error', 'Failed to process image: ' . $e->getMessage());
                        // Ré-affiche la page d'ajout AVEC le formulaire et ses erreurs
                        return $this->render('events/add_event.html.twig', ['create_event_form' => $form->createView()]);
                     }
                 } else {
                     $this->addFlash('error', 'Uploaded image is invalid: ' . $imageFile->getErrorMessage());
                     // Ré-affiche la page d'ajout AVEC le formulaire et ses erreurs
                     return $this->render('events/add_event.html.twig', ['create_event_form' => $form->createView()]);
                 }
            } else { $event->setImage(''); } // Pas d'image ou optionnelle

            // --- Persistance ---
            try {
                // Vérif. finale (optionnelle si contraintes bien définies)
                if ($event->getName() === null || $event->getDescription() === null /* ... */) {
                     throw new \LogicException('Data missing before persist.');
                }
                $em->persist($event);
                $em->flush();
                $this->addFlash('success', sprintf('Event "%s" created successfully!', $event->getName()));
                // Redirection vers la LISTE après succès
                return $this->redirectToRoute('app_events');

            } catch (\Exception $e) { // Erreur pendant flush()
                $this->logger->error('Database error saving event: ' . $e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', 'A database error occurred. Please check your data and try again.');
                 // Ré-affiche la page d'ajout AVEC le formulaire et ses erreurs (l'erreur DB peut être liée aux données)
                 return $this->render('events/add_event.html.twig', ['create_event_form' => $form->createView()]);
            }
        // --- Si le formulaire est soumis mais INVALIDE ---
        } else { // Pas besoin de revérifier isSubmitted() ici car handleRequest l'a déjà fait
             $this->logger->warning('Add event form submitted but INVALID.');
            // Pas besoin de flash message ici, les erreurs sont dans le formulaire

            // Ré-affiche la PAGE D'AJOUT avec le formulaire contenant les données
            // soumises et les messages d'erreur de validation attachés aux champs.
            return $this->render('events/add_event.html.twig', [
                'create_event_form' => $form->createView(),
            ]);
        }
    }
}