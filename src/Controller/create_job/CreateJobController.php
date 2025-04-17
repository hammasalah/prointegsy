<?php

namespace App\Controller\create_job;

use App\Entity\Jobs;
use App\Form\CreateJobFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// class CreateJobController extends AbstractController
// {
//     #[Route('/create/job', name: 'app_create_job')]
//     public function index(Request $request, EntityManagerInterface $entityManager): Response
//     {
//         $job = new Jobs();
//         $form = $this->createForm(CreateJobFormType::class, $job);

//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             $user = $this->getUser(); // currently authenticated user
//             if (!$user) {
//                 throw $this->createAccessDeniedException('You must be logged in.');
//             }
//             $job->setUserId($user instanceof \App\Entity\Users ? $user : null); // set the user who created the job
            
//             $entityManager->persist($job);
//             $entityManager->flush();

//             // You can redirect to a success page or back to the form
//             return $this->redirectToRoute('app-root');
//         }

//         return $this->render('create_job/root.html.twig', [
//             'form' => $form->createView(),
//         ]);
//     }
// }

namespace App\Controller\create_job;

use App\Entity\Jobs;
use App\Form\CreateJobFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateJobController extends AbstractController
{
    #[Route('/create/job', name: 'app_create_job')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $job = new Jobs();
        $form = $this->createForm(CreateJobFormType::class, $job);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($job);
            $entityManager->flush();

            // You can redirect to a success page or back to the form
            return $this->redirectToRoute('app_create_job');
        }

        return $this->render('create_job/createjob.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
