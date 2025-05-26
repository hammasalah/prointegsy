<?php

namespace App\Controller\jobfeed;

use App\Repository\JobsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobFeedController extends AbstractController
{
    #[Route('/job/feed', name: 'app_job_feed')]
    public function index(JobsRepository $jobsRepository): Response
    {
        $jobs = $jobsRepository->findAllSortedByTitle();

    
        return $this->render('jobfeed/jobFeed.html.twig', [
            'jobs' => $jobs,
        ]);
    }
}
