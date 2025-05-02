<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Form\ActualiteType;
use App\Repository\ActualiteRepository;
use App\Repository\UERepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/actualite')]
class ActualiteController extends AbstractController
{
    //Route pour créer une nouvelle actualité liée à une UE
    #[Route('/new/{code_ue}', name: 'actualite_new', methods: ['GET', 'POST'])] 
    public function new(string $code_ue, Request $request, EntityManagerInterface $entityManager, UERepository $ueRepository): Response
    {
        // Crée une nouvelle instance d’Actualite
        $actualite = new Actualite();
        $actualite->setDatetimeAct(new \DateTime()); // définir date temps au moment
        $actualite->setUser($this->getUser()); // Associer l'utilisateur connecté à l'actualité

        $ue = $ueRepository->findOneBy(['codeUE' => $code_ue]); //
        if (!$ue) {
            // Si l'UE n'est pas trouvée, on lance une exception 404
            throw $this->createNotFoundException('UE not found.');
        }
        $actualite->setCodeUE($ue); // Associer l'UE à l'actualité

        // Crée le formulaire pour l'actualité
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);


        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($actualite);
            $entityManager->flush();

            // Redirige vers la liste des actualités après la création
            return $this->redirectToRoute('choixUE');
        }

        // Si le formulaire n'est pas soumis ou valide, on affiche le formulaire
        return $this->render('actualite/new.html.twig', [
            'form' => $form,
        ]);
    }


    //Route pour afficher la liste des actualités
    #[Route('/list', name: 'actualite_list', methods: ['GET'])]
    public function list(ActualiteRepository $actualiteRepository): Response
    {
        
        /** @var \App\Entity\User $user */ 
        $user = $this->getUser(); // Récupère l'utilisateur connecté
    
        
        $ues = $user->getListeUe(); // Récupère la liste des UEs de l'utilisateur
    
        
        $actualites = $actualiteRepository->findByUes($ues); // Récupère les actualités liées aux UEs de l'utilisateur


        // Si l'utilisateur n'a pas d'UE, on redirige vers une autre page ou on affiche un message
        return $this->render('choixUE.html.twig', [
            'actualites' => $actualites,
        ]);
    }
}
