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
use Symfony\Component\HttpFoundation\JsonResponse;

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

    // view pdf
    #[Route('/view/{idPost}', name: 'pdf_view')]
    public function viewPdf(int $idPost, PostRepository $postRepository): Response
    {
        $post = $postRepository->find($idPost);
        if (!$post || !$post->getDepotPostBlob()) {
            throw $this->createNotFoundException('Aucun fichier trouvé.');
        }

        $blob = $post->getDepotPostBlob();
        if (is_resource($blob)) {
            $blob = stream_get_contents($blob);
        }

        return new Response(
            $blob,
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $post->getDepotPostName() . '"',
            ]
        );
    }

    // edit post
    #[Route('/edit/{idPost}', name: 'post_edit', methods: ['GET', 'POST'])]
    public function edit(string $code_ue, Request $request, int $idPost, EntityManagerInterface $em, UERepository $ueRepository): Response
    {
        $post = $em->getRepository(Post::class)->find($idPost);

        if (!$post) {
            return new JsonResponse(['error' => 'Post not found'], 404);
        }

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $request->files->get('post')['depotPostBlob'] ?? null;

            if ($uploadedFile) {
                $post->setDepotPostName($uploadedFile->getClientOriginalName());
                $post->setDepotPostBlob(file_get_contents($uploadedFile->getPathname()));
            }
            $em->flush();

            return $this->redirectToRoute('contenu_UE', ['code_ue' => $code_ue], Response::HTTP_SEE_OTHER);
        }
        $ue = $ueRepository->find($code_ue);
        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
            'ue' => $ue
        ]);
    }

    // delete post
    #[Route('/delete/{idPost}', name: 'post_delete', methods: ['DELETE'])]
    public function delete(string $code_ue, int $idPost, EntityManagerInterface $em, Request $request): JsonResponse
    {
        $post = $em->getRepository(Post::class)->find($idPost);

        if (!$post) {
            return new JsonResponse(['error' => 'Post not found'], 404);
        }

        $submittedToken = $request->headers->get('X-CSRF-TOKEN');
        if (!$this->isCsrfTokenValid('delete-post', $submittedToken)) {
            return new JsonResponse(['error' => 'Invalid CSRF token'], 403);
        }

        $em->remove($post);
        $em->flush();

        return new JsonResponse(['success' => true]);
    }
}
