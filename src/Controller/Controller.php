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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class Controller extends AbstractController
{
    // Route Par Defaut
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_login');
    }



    // Mes Cours
    #[Route('/mes-cours', name: 'choixUE')]
    public function choixUE(UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('User not logged in.');
        }
        $ues = $user->getListeUe(); // returns Collection<UE>
        return $this->render('choixUE.html.twig', [
            'ues' => $ues,
        ]);
    }

    #[Route('/mes-cours/{code_ue}/participants', name: 'participants_UE')]
    public function showParticipants(string $code_ue, UERepository $ueRepository, UserRepository $userRepository): Response
    {
        $ue = $ueRepository->findOneBy(['codeUE' => $code_ue]);
        
        if (!$ue) {
            throw $this->createNotFoundException('UE not found');
        }

        $students = $userRepository->findByUeAndRole($ue, 'ROLE_ETUDIANT');
        $professors = $userRepository->findByUeAndRole($ue, 'ROLE_PROF');

        return $this->render('participants.html.twig', [
            'ue' => $ue,
            'students' => $students,
            'professors' => $professors,
        ]);
    }
    

    // Editer Profile
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

