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
        return $this->render('index.html.twig');
    }

    #[Route('/profile', name:'profile')]
    public function login() : Response
    {
        return $this->render('profile.html.twig');
    }

    #[Route('/UE/contenu', name:'contenu_UE')]
    public function contenu_UE() : Response
    {
        return $this->render('contenu_ue.html.twig');
    }
}