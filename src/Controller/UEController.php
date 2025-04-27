<?php

namespace App\Controller;

use App\Entity\UE;
use App\Form\UEType;
use App\Repository\UERepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/ue')]
final class UEController extends AbstractController
{
    #[Route(name: 'app_u_e_index', methods: ['GET'])]
    public function index(UERepository $uERepository): Response
    {
        return $this->render('ue/index.html.twig', [
            'ues' => $uERepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_u_e_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $uE = new UE();
        $form = $this->createForm(UEType::class, $uE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload
            $imageFile = $form->get('image_ue')->getData();
            
            if ($imageFile) {
                try {
                    $uE->setImageMimeTypeUE($imageFile->getMimeType());
                    $uE->setImageUE(file_get_contents($imageFile->getPathname()));
                } catch (FileException $e) {
                    $this->addFlash('error', 'Error uploading image: '.$e->getMessage());
                    return $this->redirectToRoute('app_u_e_new');
                }
            }

            $entityManager->persist($uE);
            $entityManager->flush();

            $this->addFlash('success', 'UE created successfully!');
            return $this->redirectToRoute('admin_catalogue', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ue/new.html.twig', [
            'ue' => $uE,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_u_e_show', methods: ['GET'])]
    public function show(UE $uE): Response
    {
        return $this->render('ue/show.html.twig', [
            'ue' => $uE,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_u_e_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UE $uE, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UEType::class, $uE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload
            $imageFile = $form->get('image_ue')->getData();
            
            if ($imageFile) {
                try {
                    $uE->setImageMimeTypeUE($imageFile->getMimeType());
                    $uE->setImageUE(file_get_contents($imageFile->getPathname()));
                } catch (FileException $e) {
                    $this->addFlash('error', 'Error updating image: '.$e->getMessage());
                    return $this->redirectToRoute('app_u_e_edit', ['id' => $uE->getId()]);
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'UE updated successfully!');
            return $this->redirectToRoute('admin_catalogue', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ue/edit.html.twig', [
            'ue' => $uE,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_u_e_delete', methods: ['POST'])]
    public function delete(Request $request, UE $uE, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$uE->getCodeUE(), $request->request->get('_token'))) {
            $entityManager->remove($uE);
            $entityManager->flush();
            $this->addFlash('success', 'UE deleted successfully!');
        }

        return $this->redirectToRoute('admin_catalogue', [], Response::HTTP_SEE_OTHER);
    }
}