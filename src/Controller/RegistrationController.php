<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Ce contrôleur gère les opérations liées à l'enregistrement des utilisateurs.
 */

class RegistrationController extends AbstractController
{
    /**
     * Crée un nouvel utilisateur et l'enregistre dans la base de données.
     *
     * Cette méthode affiche un formulaire d'inscription permettant de saisir les informations d'un utilisateur.
     * Lors de la soumission, le mot de passe est haché pour garantir la sécurité. Après validation, les données
     * de l'utilisateur sont enregistrées dans la base de données.
     *
     * @Route("/user/new", name="app_register")
     *
     * @param Request $request L'objet contenant les données de la requête HTTP (incluant les données du formulaire).
     * @param UserPasswordHasherInterface $userPasswordHasher Le service permettant de hacher le mot de passe de l'utilisateur.
     * @param EntityManagerInterface $entityManager Le gestionnaire Doctrine pour persister les données dans la base de données.
     *
     * @return Response Retourne la vue du formulaire ou une redirection après l'enregistrement réussi.
     */

    #[Route('/user/new', name: 'app_register')]
    public function new(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        // Création d'un nouvel utilisateur.
        $user = new User();

        // Création et traitement du formulaire d'enregistrement.
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Récupération et hachage du mot de passe fourni.

            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            // Configuration du rôle unique pour l'utilisateur.
            $user->setSingleRole($form->get('roles')->getData());

            // Sauvegarde de l'utilisateur dans la base de données.
            $entityManager->persist($user);
            $entityManager->flush();

            /// Redirection vers la page admin.

            return $this->redirectToRoute('admin_catalogue');
        }

        // Rend la vue Twig pour afficher le formulaire d'enregistrement.
        return $this->render('user/new.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
