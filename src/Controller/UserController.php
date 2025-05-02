<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/user')]
class UserController extends AbstractController
{

    /**
     * Permet à un administrateur ou un utilisateur autorisé de modifier les informations d'un utilisateur.
     *
     * @Route("/{id}/edit", name="app_user_edit", methods={"GET", "POST"})
     *
     * @param Request $request L'objet requête qui contient les données du formulaire.
     * @param User $user L'utilisateur cible à modifier.
     * @param EntityManagerInterface $entityManager Gère les interactions avec la base de données.
     * @param UserPasswordHasherInterface $passwordHasher Service pour hacher les mots de passe.
     *
     * @return Response Retourne une réponse HTML pour afficher ou soumettre le formulaire.
     */
    
    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Crée le formulaire pour l'utilisateur ciblé.
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et est valide.
        if ($form->isSubmitted() && $form->isValid()) {

            // Vérifie si un nouveau mot de passe a été fourni.
            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                // Hache le nouveau mot de passe et l'assigne à l'utilisateur.
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }

            // Met à jour le rôle unique de l'utilisateur.
            $user->setSingleRole($form->get('roles')->getData());

            //UPDATE user
            // SET
            //     nom_user = $user->getNomUser(),
            //     prenom_user = $user->getPreomUser(),
            //     password = $user->getPassword(),
            //     roles = $user->getSingleRole(),
            //     liste_ue = $user->getListeUe()
            // WHERE id = $user->getId();

            // Effectue la mise à jour dans la base de données.
            $entityManager->flush();

            // Redirige l'utilisateur vers la liste des utilisateurs (catalogue administrateur).
            return $this->redirectToRoute('admin_catalogue');
        }

        // Rend la vue Twig pour afficher ou éditer le formulaire de l'utilisateur.
        return $this->render('user/edit.html.twig', [
            // L'utilisateur modifié.
            'user' => $user,
            // Le formulaire rendu à la vue.
            'form' => $form->createView(),
        ]);
    }


    /**
     * Supprime un utilisateur spécifique de la base de données.
     *
     * @Route("/{id}/delete", name="app_user_delete", methods={"DELETE"})
     *
     * @param Request $request L'objet requête contenant les éventuelles données.
     * @param User $user L'utilisateur à supprimer.
     * @param EntityManagerInterface $entityManager Gère les interactions avec la base de données.
     *
     * @return JsonResponse Retourne une réponse JSON pour indiquer le succès ou l'échec de la suppression.
     */

    #[Route('/{id}/delete', name: 'app_user_delete', methods: ['DELETE'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): JsonResponse
    {
        // Supprime l'utilisateur spécifié de la base de données.
        $entityManager->remove($user);
        $entityManager->flush();

        // Retourne une réponse JSON indiquant le succès de la suppression.
        return new JsonResponse(['success' => true], 200);
    }
}
