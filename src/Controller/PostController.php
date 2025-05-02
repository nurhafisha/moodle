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
// use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

// Déclaration de la route principale pour accéder aux actions liées à un cours (UE)
#[Route('/mes-cours/{code_ue}')]
final class PostController extends AbstractController
{
    // Affiche les posts d'une UE spécifique
    #[Route(name: 'contenu_UE', methods: ['GET'])]
    public function contenu_UE(string $code_ue, UERepository $ueRepository, PostRepository $postRepository): Response
    {
        // Récupération de l'UE via son code
        $ue = $ueRepository->find($code_ue);
        if (!$ue) {
            throw $this->createNotFoundException('UE not found for code: ' . $code_ue);
        }

        // Récupération des posts normaux et épinglés
        $posts = $postRepository->getPostsSorted($code_ue);
        $postsEp = $postRepository->getPostsEpingles($code_ue);
        return $this->render('post/index.html.twig', [
            'user_id' => $this->getUser()->getId(),
            'ue' => $ue,
            'posts' => $posts,
            'posts_ep' => $postsEp,
        ]);
    }

    // Crée un nouveau post dans une UE
    #[Route('/new', name: 'new_post', methods: ['GET', 'POST'])]
    public function new(string $code_ue, UERepository $ueRepository, Request $request, EntityManagerInterface $entityManager, PostRepository $postRepository): Response
    {
        // Vérifie que l'utilisateur est connecté
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException('You must be logged in to create a post.');
        }

         // Création d'un nouveau post et initialisation des champs par défaut
        $post = new Post();
        $post->setUser($this->getUser());
        $post->setDatetimePost(new \DateTime());    // definir date temps au moment
        
        // Création du formulaire PostType
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        // Traitement du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $request->files->get('post')['depotPostBlob'] ?? null;

            if ($uploadedFile) {
                $post->setDepotPostName($uploadedFile->getClientOriginalName());
                $post->setDepotPostBlob(file_get_contents($uploadedFile->getPathname()));
            }

            // Définir l'utilisateur comme épingleur si la case est cochée
            if ($form->get('epingleur')->getData()) {
                $post->setEpingleur($this->getUser());
            } else {
                $post->setEpingleur(null);
            }

            // Sauvegarde en base de données
            // INSERT INTO post(titre_post, type_post, datetimePost, description_post, depot_post_blob, code_ue, type_message, depot_post_name)
            // VALUES (
            //      $post->getTitrePost(),
            //      $post->getTypePost(),
            //      $post->getDatetimePost(),
            //      $post->getDescriptionPost(),
            //      $post->getDepotPostBlob(),
            //      $post->getCodeUE(),
            //      $post->getTypeMessage(),
            //      $post->getDepotPostName()
            // );
            $entityManager->persist($post);
            $entityManager->flush();

            // Redirection vers la page de contenu UE après la création
            return $this->redirectToRoute('contenu_UE', ['code_ue' => $code_ue], Response::HTTP_SEE_OTHER);
        }

        $ue = $ueRepository->find($code_ue);
        if (!$ue) {
            throw $this->createNotFoundException('UE not found for code: ' . $code_ue);
        }

        $posts = $postRepository->getPostsSorted($code_ue);

        return $this->render('post/index.html.twig', [
            'user_id' => $this->getUser()->getId(),
            'form' => $form,
            'posts' => $posts,
            'ue' => $ue,
        ]);
    }

    // Téléchargement du fichier joint à un post
    #[Route('/download/{idPost}', name: 'post_download')]
    public function download(int $idPost, PostRepository $postRepository): Response
    {
        $post = $postRepository->find($idPost);

        if (!$post || !$post->getDepotPostBlob()) {
            throw $this->createNotFoundException('Aucun fichier trouvé.');
        }

        $fileBlob = $post->getDepotPostBlob();
        $fileName = $post->getDepotPostName() ?? 'fichier.zip';

        // Convertit le flux en chaîne binaire si nécessaire (cas SQLite)
        if (is_resource($fileBlob)) {
            $fileBlob = stream_get_contents($fileBlob);
        }

        // Retourne la réponse HTTP pour déclencher le téléchargement
        return new Response(
            $fileBlob,
            200,
            [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }

    // Affichage du fichier PDF en ligne
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

        // Réponse HTTP avec affichage PDF intégré
        return new Response(
            $blob,
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $post->getDepotPostName() . '"',
            ]
        );
    }

    // Modification d'un post
    #[Route('/edit/{idPost}', name: 'post_edit', methods: ['GET', 'POST'])]
    public function edit(string $code_ue, Request $request, int $idPost, EntityManagerInterface $em, UERepository $ueRepository, PostRepository $postRepository): Response
    {
        $post = $em->getRepository(Post::class)->find($idPost);

        if (!$post) {
            return new JsonResponse(['error' => 'Post not found'], 404);
        }

        // Création et traitement du formulaire d'édition
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $request->files->get('post')['depotPostBlob'] ?? null;

            if ($uploadedFile) {
                $post->setDepotPostName($uploadedFile->getClientOriginalName());
                $post->setDepotPostBlob(file_get_contents($uploadedFile->getPathname()));
            }
            // UPDATE post
            // SET
            //     titre_post = $post->getTitrePost(),
            //     type_post = $post->getTypePost(),
            //     datetimePost = $post->getDatetimePost(),
            //     description_post = $post->getDescriptionPost(),
            //     depot_post_blob = $post->getDepotPostBlob(),
            //     code_ue = $post->getCodeUE(),
            //     type_message = $post->getTypeMessage(),
            //     depot_post_name = $post->getDepotPostName()
            // WHERE id_post = $post->getId();
            $em->flush(); // Mise à jour des données

            return $this->redirectToRoute('contenu_UE', ['code_ue' => $code_ue], Response::HTTP_SEE_OTHER);
        }

        // Affiche de nouveau la page avec formulaire prérempli
        $ue = $ueRepository->find($code_ue);
        $posts = $postRepository->getPostsSorted($code_ue);
        return $this->render('post/index.html.twig', [
            'user_id' => $this->getUser()->getId(),
            'form' => $form,
            'posts' => $posts,
            'ue' => $ue,
        ]);
    }

    // Suppression d'un post
    #[Route('/delete/{idPost}', name: 'post_delete', methods: ['DELETE'])]
    public function delete(string $code_ue, int $idPost, EntityManagerInterface $em, Request $request, PostRepository $postRepository): JsonResponse
    {
        $post = $em->getRepository(Post::class)->find($idPost);

        if (!$post) {
            return new JsonResponse(['error' => 'Post not found'], 404);
        }

        // Vérification du token CSRF
        $submittedToken = $request->headers->get('X-CSRF-TOKEN');
        if (!$this->isCsrfTokenValid('delete-post', $submittedToken)) {
            return new JsonResponse(['error' => 'Invalid CSRF token'], 403);
        }

        // Suppression et mise à jour de la base
        // DELETE FROM post WHERE id_post = $post->getId();
        $em->remove($post);
        $em->flush();

        return new JsonResponse(['success' => true]);
    }

    // Retourne les données d’un post sous forme JSON (pour affichage/modification dynamique)
    #[Route('/data/{id}', name: 'post_data')]
    public function postData(PostRepository $postRepository, int $id): JsonResponse
    {
        $post = $postRepository->find($id);

        if (!$post) {
            return new JsonResponse(['error' => 'Post not found'], 404);
        }

        // Données structurées en JSON
        return new JsonResponse([
            'titrePost' => $post->getTitrePost(),
            'descriptionPost' => $post->getDescriptionPost(),
            'typePost' => $post->getTypePost(),
            'datetimePost' => $post->getDatetimePost()?->format('Y-m-d\TH:i:s'),
            'codeUE' => $post->getCodeUE()?->getCodeUE(),
            'typeMessage' => $post->getTypeMessage(),
            'depotPostName' => $post->getDepotPostName(),
            'epingleur' => $post->getEpingleur()?->getId(),
        ]);
    }

}
