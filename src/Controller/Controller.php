<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;

class Controller extends AbstractController
{
    // Route Par Defaut
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_login');
    }

    // Profile
    #[Route('/profile', name: 'profile')]
    public function login(): Response
    {
        return $this->render('profile.html.twig');
    }

    // Mes Cours
    #[Route('/mes-cours', name: 'choixUE')]
    public function choixUE(UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('User not logged in.');
        }
        $user = $userRepository->find($user->getId());
        $ues = $user->getListeUe(); // returns Collection<UE>
        return $this->render('choixUE.html.twig', [
            'ues' => $ues,
        ]);
    }

    // Contenu d'une UE
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

    // Editer Profile
    #[Route('/edit', name: 'edit_profile')]
    public function edit_profile(): Response
    {
        return $this->render('editProfile.html.twig');
    }
}
