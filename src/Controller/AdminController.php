<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\UERepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Controlleur gérant les fonctionnalités d'administration.
 * Ce fichier inclut la gestion du catalogue pour les utilisateurs
 * et les UEs (Unités d'Enseignement).
 */

class AdminController extends AbstractController
{
    /**
     * Route vers la page catalogue dans l'administration.
     *
     * @Route("/admin/catalogue", name="admin_catalogue")
     *
     * @param UserRepository $userRepository Permet d'accéder aux données des utilisateurs via le dépôt.
     * @param UERepository $UeRepos Permet d'accéder aux données des unités d'enseignement via le dépôt.
     * @return Response Retourne une réponse contenant la vue du catalogue.
     */

    #[Route('/admin/catalogue', name: 'admin_catalogue')]
    public function catalogue(UserRepository $userRepository, UeRepository $UeRepos): Response
    {
        // Récupération de la liste de tous les utilisateurs.
        $users = $userRepository->findAll();

        // Récupération de la liste de toutes les unités d'enseignement (UEs).
        $ues = $UeRepos->findAll();


        // Rendu de la vue 'admin_catalogue.html.twig' avec les données des utilisateurs et des UEs.
        return $this->render('admin_catalogue.html.twig', [

            // Liste des utilisateurs envoyée à la vue.
            'users' => $users,

            // Liste des unités d'enseignement envoyée à la vue.
            'ues' => $ues


        ]);
    }
}
