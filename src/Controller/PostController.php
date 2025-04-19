<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UERepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/mes-cours/{code_ue}')]
final class PostController extends AbstractController
{
    // contenu-ue
    #[Route(name: 'contenu_UE', methods: ['GET'])]
    public function contenu_UE(string $code_ue, UERepository $ueRepository, PostRepository $postRepository): Response
    {
        $ue = $ueRepository->find($code_ue);
        if (!$ue) {
            throw $this->createNotFoundException('UE not found for code: ' . $code_ue);
        }
        $posts = $postRepository->getPostsSorted($code_ue);
        return $this->render('post/index.html.twig', [
            'ue' => $ue,
            'posts' => $posts
        ]);
    }

    // new post
    #[Route('/new', name: 'new_post', methods: ['GET', 'POST'])]
    public function new(string $code_ue, UERepository $ueRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $post->setDatetimePost(new \DateTime());    // definir date temps au moment
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $request->files->get('post')['depotPostBlob'] ?? null;

            if ($uploadedFile) {
                $post->setDepotPostName($uploadedFile->getClientOriginalName());
                $post->setDepotPostBlob(file_get_contents($uploadedFile->getPathname()));
            }

            $post->setDatetimePost(new \DateTime());
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('contenu_UE', ['code_ue' => $code_ue], Response::HTTP_SEE_OTHER);
        }

        $ue = $ueRepository->find($code_ue);
        if (!$ue) {
            throw $this->createNotFoundException('UE not found for code: ' . $code_ue);
        }
        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
            'ue' => $ue
        ]);
    }

    // telechargement fichier depot
    #[Route('/download/{idPost}', name: 'post_download')]
    public function download(int $idPost, PostRepository $postRepository): Response
    {
        $post = $postRepository->find($idPost);

        if (!$post || !$post->getDepotPostBlob()) {
            throw $this->createNotFoundException('Aucun fichier trouvé.');
        }

        $fileBlob = $post->getDepotPostBlob();
        $fileName = $post->getDepotPostName() ?? 'fichier.zip';

        // Handle resource type (e.g., SQLite blob)
        if (is_resource($fileBlob)) {
            $fileBlob = stream_get_contents($fileBlob);
        }

        return new Response(
            $fileBlob,
            200,
            [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }

    // edit post
    #[Route('/{idPost}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    // delete post
    #[Route('/{idPost}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getIdPost(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
