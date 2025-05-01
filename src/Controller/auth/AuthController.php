<?php

namespace App\Controller\auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RegistrationFormType;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(Request $request, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        // If user is already logged in
        if ($session->get('user')) {
          //  return $this->redirectToRoute('app_login');
        }
    
        $error = null;
        $lastEmail = $request->request->get('email', '');
    
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');
    
            $user = $entityManager->getRepository(Users::class)->findOneBy(['email' => $email]);
    
            if (!$user || $user->getPassword() !== $password) {
                $error = 'Invalid credentials';
            } else {
                $session->set('user', $user);
                return $this->redirectToRoute('app_job_feed');
            }
        }
    
        return $this->render('auth/login.html.twig', [
            'error' => $error,
            'last_username' => $lastEmail
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(SessionInterface $session): Response
    {
        $session->remove('user');
        return $this->redirectToRoute('app_login');
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // Set basic user data
                $user->setCreatedAt(date('Y-m-d H:i:s'));
                $user->setPoints(0);
                $user->setArgent(0);
                
                // Store plain password (not recommended for production)
                $plainPassword = $form->get('plainPassword')->getData();
                $user->setPassword($plainPassword);

                // Save the user
                $entityManager->persist($user);
                $entityManager->flush();
                
                $this->addFlash('success', 'Registration successful! You can now log in.');
                return $this->redirectToRoute('app_login');
            } else {
                // Collect all form errors
                $errors = [];
                foreach ($form->getErrors(true) as $error) {
                    $errors[] = $error->getMessage();
                }
                $this->addFlash('error', implode('<br>', $errors));
            }
        }

        return $this->render('auth/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}