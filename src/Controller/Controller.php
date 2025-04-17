<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\UserRepository;
use App\Repository\UERepository;
use App\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
        $ues = $user->getListeUe(); // returns Collection<UE>
        return $this->render('choixUE.html.twig', [
            'ues' => $ues,
        ]);
    }

    // Contenu d'une UE
    // #[Route('/mes-cours/{code_ue}', name: 'contenu_UE')]
    // public function contenu_UE(string $code_ue, UERepository $ueRepository, PostRepository $postRepository): Response
    // {
    //     $ue = $ueRepository->find($code_ue);
    //     if (!$ue) {
    //         throw $this->createNotFoundException('UE not found for code: ' . $code_ue);
    //     }
    //     $posts = $postRepository->getPostsSorted($code_ue);
    //     return $this->render('contenu_ue.html.twig', [
    //         'ue' => $ue,
    //         'posts' => $posts,
    //     ]);
    // }

    // #[Route('/mes-cours/{code_ue}/post/{slug}', name: 'new_post')]
    // public function new_post(string $code_ue, string $slug, UERepository $ueRepository): Response
    // {
    //     $ue = $ueRepository->find($code_ue);
    //     if (!$ue) {
    //         throw $this->createNotFoundException('UE not found for code: ' . $code_ue);
    //     }
    //     return $this->render('post.html.twig', [
    //         'ue' => $ue,
    //         'slug' => $slug
    //     ]);
    // }

    #[Route('/mes-cours/{code_ue}/post/{slug}/{id?}', name: 'edit_post')]
    public function edit_post(string $code_ue, int $id, string $slug, UERepository $ueRepository): Response
    {
        $ue = $ueRepository->find($code_ue);
        if (!$ue) {
            throw $this->createNotFoundException('UE not found for code: ' . $code_ue);
        }
        return $this->render('post.html.twig', [
            'ue' => $ue,
            'id' => $id,
            'slug' => $slug
        ]);
    }

    #[Route('/mes-cours/{code_ue}/participants', name: 'participants_UE')]
    public function participants_UE(string $code_ue, UERepository $ueRepository): Response
    {
        $ue = $ueRepository->find($code_ue);
        if (!$ue) {
            throw $this->createNotFoundException('UE not found for code: ' . $code_ue);
        }
        return $this->render('participants.html.twig', [
            'ue' => $ue,
        ]);
    }

    #[Route('/post/{post_id}/download', name: 'post_download')]
    public function downloadFile(int $post_id, EntityManagerInterface $entityManager): Response
    {
        $post = $entityManager->getRepository(Post::class)->find($post_id);
        
        if (!$post || !$post->getDepotPost()) {
            throw $this->createNotFoundException('Aucun fichier disponible.');
        }

        $fileData = $post->getDepotPost();
        
        return new Response($fileData, Response::HTTP_OK, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $post->getTitrePost() . '"',
        ]);
    }

    // Editer Profile
    #[Route('/edit', name: 'edit_profile')]
    public function edit_profile(): Response
    {
        return $this->render('editProfile.html.twig');
    }
}
