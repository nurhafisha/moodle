<?php

namespace App\Controller;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, UserRepository $userRepository): Response
    {
        if ($this->getUser()) {
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('admin_catalogue'); // Role admin route
            }
            return $this->redirectToRoute('choixUE');
        }


        // obtenir l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier nom d'utilisateur saisi par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        // Récupérer les statistiques des utilisateurs
        $userStats = $userRepository->getUserStatistics();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error , 'user_stats' => $userStats]);
    }

    // Cette méthode est gérée par le pare-feu de sécurité et ne doit pas être appelée directement
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): never
    {
        throw new \LogicException('Cette méthode peut être vide : elle sera interceptée par la clé de déconnexion de votre pare-feu.');
        
    }


}
