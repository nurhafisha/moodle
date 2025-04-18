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
}



//  #[Route('/user/image/{id}', name:'user_image')]
// public function userImage(User $user): Response
// {
//     $imageData = $user->getImageData();
//     $mimeType = $user->getImageMimeType();

//     if (!$imageData || !$mimeType) {
//         throw $this->createNotFoundException('Image not found');
//     }

//     return new Response($imageData, 200, [
//         'Content-Type' => $mimeType,
//         'Content-Disposition' => 'inline; filename="profile.jpg"'
//     ]);
// }