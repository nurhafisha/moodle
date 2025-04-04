<?php

namespace App\Controller;

use App\Entity\UE;
use App\Form\UEType;
use App\Repository\UERepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ue')]
final class UEController extends AbstractController
{
    #[Route(name: 'app_u_e_index', methods: ['GET'])]
    public function index(UERepository $uERepository): Response
    {
        return $this->render('ue/index.html.twig', [
            'u_es' => $uERepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_u_e_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $uE = new UE();
        $form = $this->createForm(UEType::class, $uE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Handle the uploaded file
            $imageFile = $form->get('imageUE')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'), // Directory where images will be stored
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                }

                // Update the 'imageUE' property to store the image file name
                $uE->setImageUE($newFilename);
            }
            $entityManager->persist($uE);
            $entityManager->flush();

            return $this->redirectToRoute('app_u_e_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ue/new.html.twig', [
            'ue' => $uE,
            'form' => $form,
        ]);
    }

    #[Route('/{idUE}', name: 'app_u_e_show', methods: ['GET'])]
    public function show(UE $uE): Response
    {
        return $this->render('ue/show.html.twig', [
            'ue' => $uE,
        ]);
    }

    #[Route('/{idUE}/edit', name: 'app_u_e_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UE $uE, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UEType::class, $uE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_u_e_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ue/edit.html.twig', [
            'ue' => $uE,
            'form' => $form,
        ]);
    }

    #[Route('/{idUE}', name: 'app_u_e_delete', methods: ['POST'])]
    public function delete(Request $request, UE $uE, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $uE->getIdUE(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($uE);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_u_e_index', [], Response::HTTP_SEE_OTHER);
    }
}
