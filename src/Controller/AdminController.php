<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\UERepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/catalogue', name: 'admin_catalogue')]
    public function catalogue(UserRepository $userRepository, UeRepository $UeRepos): Response
    {
        $users = $userRepository->findAll();
        $ues = $UeRepos->findAll();


        // Rendu de la vue 'admin_catalogue.html.twig' avec les données des utilisateurs et des UEs.

        return $this->render('admin_catalogue.html.twig', [
            'users' => $users,

            'ues' => $ues
        ]);
    }
}
