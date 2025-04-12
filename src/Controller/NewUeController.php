<?php

namespace App\Controller;

use App\Entity\NewUe;
use App\Form\NewUeType;
use App\Repository\NewUeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/new/ue')]
final class NewUeController extends AbstractController
{
    #[Route(name: 'app_new_ue_index', methods: ['GET'])]
    public function index(NewUeRepository $newUeRepository): Response
    {
        // Fetch all UEs from the database
        $new_ues = $newUeRepository->findAll();

        return $this->render('new_ue/index.html.twig', [
            'new_ues' => $newUeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_new_ue_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newUe = new NewUe();
        $form = $this->createForm(NewUeType::class, $newUe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($newUe);
            $entityManager->flush();

            return $this->redirectToRoute('admin_catalogue', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('new_ue/new.html.twig', [
            'new_ue' => $newUe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_new_ue_show', methods: ['GET'])]
    public function show(NewUe $newUe): Response
    {
        return $this->render('new_ue/show.html.twig', [
            'new_ue' => $newUe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_new_ue_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NewUe $newUe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NewUeType::class, $newUe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_catalogue', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('new_ue/edit.html.twig', [
            'new_ue' => $newUe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_new_ue_delete', methods: ['POST'])]
    public function delete(Request $request, NewUe $newUe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $newUe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($newUe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_catalogue', [], Response::HTTP_SEE_OTHER);
    }
}
