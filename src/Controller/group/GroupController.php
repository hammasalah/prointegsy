<?php

namespace App\Controller\group;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupController extends AbstractController
{
    #[Route('/group', name: 'app_group')]
    public function index(): Response
    {
        return $this->render('group/group.html.twig', [
            'controller_name' => 'GroupController',
        ]);
    }
}
