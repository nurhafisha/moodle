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
     * Cette méthode gère la création d'une UE, y compris le téléchargement d'une image associée.
     * Si le formulaire est soumis et valide, l'UE est enregistrée dans la base de données.
     *
     * @Route('/new', name='app_u_e_new', methods={'GET', 'POST'})
     *
     * @param Request $request L'objet Request contenant les données de la requête.
     * @param EntityManagerInterface $entityManager Le gestionnaire Doctrine pour persister les données.
     *
     * @return Response Retourne une réponse HTTP avec le formulaire ou une redirection.
     */
    #[Route('/new', name: 'app_u_e_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle instance de l'entité UE.
        $uE = new UE();
        // Création du formulaire associé à l'entité UE.
        $form = $this->createForm(UEType::class, $uE);
        $form->handleRequest($request);

        // Vérifie si le formulaire est soumis et valide.
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère le fichier image soumis.
            $imageFile = $form->get('image_ue')->getData();

            // Vérifie si un fichier a été téléchargé.
            if ($imageFile) {
                try {
                    $uE->setImageMimeTypeUE($imageFile->getMimeType());
                    // Stocke le contenu de l'image.
                    $uE->setImageUE(file_get_contents($imageFile->getPathname()));
                } catch (FileException $e) {
                    $this->addFlash('error', 'Error uploading image: ' . $e->getMessage());

                    // Redirige vers le formulaire.
                    return $this->redirectToRoute('app_u_e_new');
                }
            }

            // Persiste l'entité UE dans la base de données.
            $entityManager->persist($uE);
            // Sauvegarde les modifications dans la base de données.

            $entityManager->flush();

            $this->addFlash('success', 'UE created successfully!');

            // Redirige vers le catalogue.
            return $this->redirectToRoute('admin_catalogue', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ue/new.html.twig', [
            'ue' => $uE,
            'form' => $form->createView(),
        ]);
    }


    /**
     * Modifie UE existante.
     *
     * Cette méthode permet de modifier une UE, y compris la mise à jour de l'image associée.
     *
     * @Route('/{id}/edit', name='app_u_e_edit', methods={'GET', 'POST'})
     *
     * @param Request $request L'objet Request contenant les données de la requête.
     * @param UE $uE L'entité UE à modifier.
     * @param EntityManagerInterface $entityManager Le gestionnaire Doctrine pour persister les modifications.
     *
     * @return Response Retourne une réponse HTTP avec le formulaire ou une redirection.
     */
    #[Route('/{id}/edit', name: 'app_u_e_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UE $uE, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UEType::class, $uE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

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

            // Sauvegarde les modifications dans la base de données.
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
