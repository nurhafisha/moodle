<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
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
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if a new password is provided
            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                // Hash the new password
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }
            $user->setSingleRole($form->get('roles')->getData());

            //UPDATE user
            // SET
            //     nom_user = $user->getNomUser(),
            //     prenom_user = $user->getPreomUser(),
            //     password = $user->getPassword(),
            //     roles = $user->getSingleRole(),
            //     liste_ue = $user->getListeUe()
            // WHERE id = $user->getId();

            $entityManager->flush();

            return $this->redirectToRoute('admin_catalogue');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
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
        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse(['success' => true], 200);
    }
}
