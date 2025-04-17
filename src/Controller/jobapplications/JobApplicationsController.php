<?php

namespace App\Controller\jobapplications;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobApplicationsController extends AbstractController
{
    #[Route('/job/applications', name: 'app_job_applications')]
    public function index(): Response
    {
        return $this->render('jobapplications/jobapplications.html.twig', [
            'controller_name' => 'JobApplicationsController',
        ]);
    }
}
