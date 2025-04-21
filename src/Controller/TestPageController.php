<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TestPageController extends AbstractController
{
    #[Route('/testpage', name: 'app_test')]
    public function index(): Response
    {

        return $this->render('test/test.html.twig');
    }

    #[Route('/admintest', name: 'app_test_admin')]
    public function adminTest(): Response
    {
        return $this->render('test/test_admin.html.twig');
    }
}
