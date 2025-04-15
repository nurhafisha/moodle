<?php 
namespace App\Controller;

use App\Entity\User; 
use App\Form\ProfileEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProfileController extends AbstractController
{
    #[Route('/edit', name:'edit_profile')]
    public function edit_profile(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = $this->getUser(); 
        
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('tu n es pas connecté');
        }
    
        $form = $this->createForm(ProfileEditType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            //changer mot de passe:
            $plainPassword = $form->get('password')->getData();
            if ($plainPassword) {
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }

            //image:
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                $user->setImageMimeType($imageFile->getMimeType());
                $user->setImageData(file_get_contents($imageFile->getPathname()));
            }

            if($telephone = $form->get('telephone')->getData()){
                $user->setTelephone($telephone);
            }

            //update:
            $entityManager->flush();
            $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');
            return $this->redirectToRoute('edit_profile');
        }
    
        // Render the form
        return $this->render('editProfile.html.twig', [
            'user' => $user,
            'form' => $form->createView()
            
        ]);
    }

    
}