<?php

namespace App\Controller;

use App\Entity\UE;
use App\Form\UEType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/ue')]
final class UEController extends AbstractController
{

    /**
     * Crée une nouvelle Unité d'Enseignement (UE).
     *
     * Cette méthode permet de créer une nouvelle UE à l'aide d'un formulaire.
     * Elle gère également le téléversement (upload) d'une image associée à l'UE,
     * en stockant son contenu et son type MIME en base de données.
     *
     * @Route("/new", name="app_u_e_new", methods={"GET", "POST"})
     *
     * @param Request $request L'objet Request qui contient les données du formulaire.
     * @param EntityManagerInterface $entityManager Le gestionnaire Doctrine pour persister l'UE dans la base de données.
     *
     * @return Response Retourne une vue HTML du formulaire ou effectue une redirection après création.
     */

    #[Route('/new', name: 'app_u_e_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $uE = new UE();
        // Création et traitement du formulaire pour une nouvelle UE.
        $form = $this->createForm(UEType::class, $uE);
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et est valide.
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion du téléversement de fichier image.
            $imageFile = $form->get('image_ue')->getData();

            if ($imageFile) {
                try {
                    // Stockage du type MIME et du contenu de l'image téléversée.
                    $uE->setImageMimeTypeUE($imageFile->getMimeType());
                    $uE->setImageUE(file_get_contents($imageFile->getPathname()));
                } catch (FileException $e) {
                    // Gère les exceptions de téléversement d'images.
                    $this->addFlash('error', 'Error uploading image: ' . $e->getMessage());
                    return $this->redirectToRoute('app_u_e_new');
                }
            }

            // Persistance de l'UE dans la base de données.
            $entityManager->persist($uE);
            $entityManager->flush();

            $this->addFlash('success', 'UE created successfully!');
            return $this->redirectToRoute('admin_catalogue', [], Response::HTTP_SEE_OTHER);
        }

        // Rend la vue Twig avec le formulaire de création d'UE.
        return $this->render('ue/new.html.twig', [
            'ue' => $uE,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modifier une Unité d'Enseignement (UE) existante.
     *
     * Cette méthode permet de modifier les informations d'une UE existante.
     * Elle gère également la mise à jour de l'image associée à l'UE.
     *
     * @Route("/{id}/edit", name="app_u_e_edit", methods={"GET", "POST"})
     *
     * @param Request $request L'objet Request contenant les données du formulaire.
     * @param UE $uE L'UE ciblée par la requête (correspondant à l'ID passé dans l'URL).
     * @param EntityManagerInterface $entityManager Le gestionnaire Doctrine pour mettre à jour l'UE dans la base de données.
     *
     * @return Response Retourne une vue HTML du formulaire ou effectue une redirection après modification.
     */

    #[Route('/{id}/edit', name: 'app_u_e_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UE $uE, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UEType::class, $uE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer le téléchargement d'images
            $imageFile = $form->get('image_ue')->getData();

            if ($imageFile) {
                try {
                    $uE->setImageMimeTypeUE($imageFile->getMimeType());
                    $uE->setImageUE(file_get_contents($imageFile->getPathname()));
                } catch (FileException $e) {
                    $this->addFlash('error', 'Error updating image: ' . $e->getMessage());
                    return $this->redirectToRoute('app_u_e_edit', ['id' => $uE->getId()]);
                }
            }

            // Met à jour les données de l'UE dans la base de données.
            $entityManager->flush();

            $this->addFlash('success', 'UE updated successfully!');
            return $this->redirectToRoute('admin_catalogue', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ue/edit.html.twig', [
            'ue' => $uE,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Supprime une Unité d'Enseignement (UE) spécifique.
     *
     * Cette méthode supprime une UE de la base de données selon l'ID spécifié.
     * Une réponse JSON est renvoyée pour confirmer la réussite de l'opération.
     *
     * @Route("/{id}/delete", name="app_u_e_delete", methods={"DELETE"})
     *
     * @param Request $request L'objet Request contenant éventuellement des données supplémentaires.
     * @param UE $ue L'UE ciblée par la requête (identifiée par son ID).
     * @param EntityManagerInterface $entityManager Le gestionnaire Doctrine pour effectuer la suppression.
     *
     * @return JsonResponse Retourne une réponse JSON confirmant la suppression avec un statut HTTP 200.
     */

    #[Route('/{id}/delete', name: 'app_u_e_delete', methods: ['DELETE'])]
    public function delete(Request $request, UE $ue, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($ue);
        $entityManager->flush();

        return new JsonResponse(['success' => true], 200);
    }
}
