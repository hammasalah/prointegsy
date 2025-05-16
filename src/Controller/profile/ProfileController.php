<?php

namespace App\Controller\profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(SessionInterface $session): Response
    {
        // Check if user is logged in
        if (!$session->has('user')) {
            return $this->redirectToRoute('app_login');
        }
        
        // Get the user object from session
        $user = $session->get('user');
        
        return $this->render('profile/index.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function edit(Request $request, SessionInterface $session): Response
    {
        if (!$session->has('user')) {
            return $this->redirectToRoute('app_login');
        }
        
        /** @var Users $user */
        $user = $session->get('user');
        
        if ($request->isMethod('POST')) {
            // Update user data using object setters
            $user->setUsername($request->request->get('username'));
            $user->setEmail($request->request->get('email'));
            $user->setAge($request->request->get('age'));
            $user->setGender($request->request->get('gender'));
            
            if ($password = $request->request->get('password')) {
                $user->setPassword($password);
            }
            
            // Update the updatedAt timestamp
            $user->setUpdatedAt(date('Y-m-d H:i:s'));
            
            // Save back to session
            $session->set('user', $user);
            
            $this->addFlash('success', 'Profile updated!');
            return $this->redirectToRoute('app_profile');
        }
        
        return $this->render('profile/edit.html.twig', [
            'user' => $user
        ]);
    }
}