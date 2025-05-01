<?php
// // src/Controller/jobfeed/JobFeedController.php
// namespace App\Controller\jobfeed;
// use App\Entity\Users;
// use App\Repository\ApplicationsRepository;
// use App\Repository\JobsRepository;
// use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

// class JobFeedController extends AbstractController
// {
//     #[Route('/job/feed/{id}' name: 'job_feed')]
    
//     public function apply(
//         int $id,
//         JobsRepository $jobsRepo,
//         ApplicationsRepository $applicationsRepo,
//         EntityManagerInterface $em
//     ): Response {
//         // 1️⃣ Fetch the Job or 404
//         $job = $jobsRepo->find($id);
//         if (!$job) {
//             throw $this->createNotFoundException('Job not found.');
//         }

//         // 2️⃣ Narrow getUser() to your Users entity
//         /** @var Users|null $user */
//         $user = $this->getUser();
//         if (!$user instanceof Users) {
//             // Either not logged in (shouldn't happen because of ROLE_USER)
//             // or your User class isn't App\Entity\Users
//             throw $this->createAccessDeniedException('You must be a valid user to apply.');
//         }

//         try {
//             // 3️⃣ Build the new Application (business logic lives in the repo)
//             $application = $applicationsRepo->createParticipation($user, $job);

//             // 4️⃣ Now persist & flush in the controller
//             $em->persist($application);
//             $em->flush();

//             $this->addFlash('success', 'Your application has been submitted!');
//         } catch (\LogicException $e) {
//             $this->addFlash('warning', $e->getMessage());
//         }

//         // 5️⃣ Redirect back to the feed
//         return $this->redirectToRoute('app_job_feed');
//     }
// } 
namespace App\Controller\jobfeed;
use App\Entity\Users;
use App\Repository\JobsRepository;
use App\Repository\ApplicationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ApplicationFormType;
use Symfony\Component\HttpFoundation\Request;

class JobFeedController extends AbstractController
{
    #[Route('/job/feed', name: 'app_job_feed')]
    public function index(JobsRepository $jobsRepository): Response
    {
        // fetch sorted jobs
        $jobs = $jobsRepository->findAllSortedByTitle();

      

        return $this->render('jobfeed/jobfeed.html.twig', [
            'jobs'=> $jobs,
           
        ]);
    }




    #[Route('/job/feed/apply/{id}', name: 'job_apply',
        methods: ['POST']     // ← only allow POSTs
    )]
    public function apply(
        int $id,
        Request $request,
        JobsRepository $jobsRepo,
        ApplicationsRepository $applicationsRepo,
        EntityManagerInterface $em
    ): Response {
        // 1️⃣ Fetch the Job or 404
        $job = $jobsRepo->find($id);
        if (!$job) {
            throw $this->createNotFoundException('Job not found.');
        }

        // 2️⃣ Pull in form data
        $coverLetter = $request->request->get('coverLetter', '');
        /** @var UploadedFile|null $cvFile */
        $cvFile      = $request->files->get('cv');

        // 3️⃣ Validate CV upload
        if (
            !$cvFile 
            || $cvFile->getClientMimeType() !== 'application/pdf' 
            || $cvFile->getSize() > 5 * 1024 * 1024
        ) {
            $this->addFlash('warning', 'Please upload a valid PDF CV under 5 MB.');
            return $this->redirectToRoute('app_job_feed');
        }

        // 4️⃣ Move the file into your uploads folder
        $uploadsDir = $this->getParameter('cv_upload_dir');
        $newName    = uniqid('cv_') . '.pdf';
        try {
            $cvFile->move($uploadsDir, $newName);
        } catch (\Exception $e) {
            $this->addFlash('warning', 'Could not save your CV. Please try again.');
            return $this->redirectToRoute('app_job_feed');
        }

        // 5️⃣ Create & persist the Application
        $user = $this->getUser();
        try {
            $application = $applicationsRepo->createApplication($user, $job);
            // if your Application entity has setters for coverLetter & cvFilename:
            $application->setCoverLetter($coverLetter);
            $application->setResumePath($newName);

            $em->persist($application);
            $em->flush();

            $this->addFlash('success', 'Your application has been submitted!');
        } catch (\LogicException $e) {
            $this->addFlash('warning', $e->getMessage());
        }

        // 6️⃣ Back to the feed
        return $this->redirectToRoute('app_job_feed');
    }
    }


