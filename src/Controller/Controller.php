<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Controller extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index() : Response
    {
        return $this->redirectToRoute('app_login');
    }

    #[Route('/profile', name:'profile')]
    public function login() : Response
    {
        return $this->render('profile.html.twig');
    }
}