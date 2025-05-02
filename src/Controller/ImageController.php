<?php 
namespace App\Controller;

use App\Entity\User; 
use App\Entity\UE;
use App\Repository\UERepository;
use App\Form\ProfileEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route('/user/image/{id}', name: 'user_image')]
    public function userImage(User $user): Response
    {
        $imageData = $user->getImageData();
        $mimeType = $user->getImageMimeType();

        if (!$imageData || !$mimeType) {
            // Return default image if no image exists
            $defaultImage = file_get_contents($this->getParameter('kernel.project_dir').'/public/images/default-profile.png');
            return new Response($defaultImage, 200, [
                'Content-Type' => 'image/png',
                'Cache-Control' => 'no-cache'
            ]);
        }

        // Handle both string and resource data types
        if (is_resource($imageData)) {
            $imageData = stream_get_contents($imageData);
        }

        return new Response($imageData, 200, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'no-cache'
        ]);
    }
    // Route pour afficher l'image d'une UE
    #[Route('/ue/image/{code_ue}', name: 'ue_image')]
    public function ueImage(string $code_ue, UERepository $ueRepository): Response
    {
        // Recherche de l’UE à partir du code
        $ue = $ueRepository->findOneBy(['codeUE' => $code_ue]); 
        
        // Si l’UE n’a pas d’image, on renvoie une image par défaut
        if (!$ue || !$ue->getImageMimeTypeUE()) {
            $defaultImage = file_get_contents($this->getParameter('kernel.project_dir').'/public/images/default-ue.png');
            return new Response($defaultImage, 200, [
                'Content-Type' => 'image/png',
                'Cache-Control' => 'no-cache'
            ]);
        }
        // Récupération de l’image et conversion si c’est un flux
        $imageData = $ue->getImageUE();
        if (is_resource($imageData)) {
            $imageData = stream_get_contents($imageData);
        }
        
        // On renvoie l’image de l’UE avec le bon type MIME
        return new Response($imageData, 200, [
            'Content-Type' => $ue->getImageMimeTypeUE(),
            'Cache-Control' => 'no-cache'
        ]);
    }
}


