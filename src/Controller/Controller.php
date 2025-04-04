<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Controller extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_login');
    }

    #[Route('/profile', name: 'profile')]
    public function login(): Response
    {
        return $this->render('profile.html.twig');
    }

    #[Route('/UE', name:'choixUE-etu')]
    public function choixUE_etu() : Response
    {
        return $this->render('choixUE-etu.html.twig');
    }

    #[Route('/choixUE-prof', name:'choixUE-prof')]
    public function choixUE_prof() : Response
    {
        return $this->render('choixUE-prof.html.twig');

    }
    //Choix UE
    #[Route('/choixUE', name: 'choixUE')]
    public function choixUE(): Response
    {
        return $this->render('choixUE-etu.html.twig');

    }

    #[Route('/UE/contenu', name: 'contenu_UE')]
    public function contenu_UE(): Response
    {
        return $this->render('contenu_ue.html.twig');
    }

    #[Route('/UE/contenu/post/{slug}', name: 'new_post')]
    public function new_post(string $slug): Response
    {
        return $this->render('post.html.twig', [
            'slug' => $slug
        ]);
    }

    #[Route('/UE/contenu/post/{slug}/{id?}', name: 'edit_post')]
    public function edit_post(int $id, string $slug): Response
    {
        return $this->render('post.html.twig', [
            'id' => $id,
            'slug' => $slug
        ]);
    }

    #[Route('/UE/contenu/participants', name: 'participants_UE')]
    public function participants_UE(): Response
    {
        return $this->render('participants.html.twig');
    }

    #[Route('/edit' , name:'edit_profile')]
    public function edit_profile():Response
    {
        return $this->render('editProfile.html.twig');
    }


}   






