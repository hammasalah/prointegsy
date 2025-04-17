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
        // Using the specific sorting method
        $jobs = $jobsRepository->findAllSortedByTitle();

        // Or using the generic sorting method:
        // $jobs = $jobsRepository->findAllWithSorting('jobTitle', 'ASC');
       

        return $this->render('jobfeed/jobFeed.html.twig', [
            'jobs' => $jobs,
        ]);
    }
}
