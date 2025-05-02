<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use App\Repository\UERepository;
use App\Repository\PostRepository;
use App\Repository\ActualiteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class Controller extends AbstractController
{
    // Route par défaut : redirige vers la page de login
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_login');
    }

    // Route pour afficher les UEs de l’utilisateur et leurs actualités
    #[Route('/mes-cours', name: 'choixUE')]
    public function choixUE(UserRepository $userRepository, ActualiteRepository $actualiteRepository): Response
    {
            
            /** @var \App\Entity\User $user */
            $user = $this->getUser(); //Utilisateur connecté
        
            
            $ues = $user->getListeUe(); // Liste des UEs de l’utilisateur
        
            
            $actualites = $actualiteRepository->findByUes($ues); // Actualités liées aux UEs

            // Affiche la page avec les UEs et leurs actualités
            return $this->render('choixUE.html.twig', [
                'actualites' => $actualites,
                'ues' => $ues
            ]);
    }


    // Route pour afficher les participants (étudiants et profs) d'une UE

    // participants dans une UE

    #[Route('/mes-cours/{code_ue}/participants', name: 'participants_UE')]
    public function showParticipants(string $code_ue, UERepository $ueRepository, UserRepository $userRepository): Response
    {   
        // Récupère l’UE par son code
        $ue = $ueRepository->findOneBy(['codeUE' => $code_ue]);
        
        if (!$ue) {
            throw $this->createNotFoundException('UE not found');
        }

        $students = $userRepository->findByUeAndRole($ue, 'ROLE_ETUDIANT'); // Liste des étudiants inscrits à l’UE
        $professors = $userRepository->findByUeAndRole($ue, 'ROLE_PROF');  // Liste des professeurs associés à l’UE

        // Affiche la page des participants
        return $this->render('participants.html.twig', [
            'ue' => $ue,
            'students' => $students,
            'professors' => $professors,
        ]);
    }
    


    // Route pour afficher la page de modification du profil utilisateur
    #[Route('/edit', name: 'edit_profile')]
    public function edit_profile(): Response
    {
        return $this->render('editProfile.html.twig');
    }

    #[Route('/test', name: 'test_page')]
    public function test(): Response
    {
        return $this->render('test.html.twig');
    }
}

