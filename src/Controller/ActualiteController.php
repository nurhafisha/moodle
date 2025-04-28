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
    #[Route('/new/{code_ue}', name: 'actualite_new', methods: ['GET', 'POST'])]
    public function new(string $code_ue, Request $request, EntityManagerInterface $entityManager, UERepository $ueRepository): Response
    {
        $actualite = new Actualite();
        $actualite->setDatetimeAct(new \DateTime());
        $actualite->setUser($this->getUser());

        $ue = $ueRepository->findOneBy(['codeUE' => $code_ue]);
        if (!$ue) {
            throw $this->createNotFoundException('UE not found.');
        }
        $actualite->setCodeUE($ue);

        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($actualite);
            $entityManager->flush();

            return $this->redirectToRoute('choixUE');
        }

        return $this->render('actualite/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/list', name: 'actualite_list', methods: ['GET'])]
    public function list(ActualiteRepository $actualiteRepository): Response
    {
        $actualites = $actualiteRepository->findBy([], ['datetimeAct' => 'DESC']);

        return $this->render('choixUE.html.twig', [
            'actualites' => $actualites,
        ]);
    }
}
