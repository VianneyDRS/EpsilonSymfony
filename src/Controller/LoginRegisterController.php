<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginRegisterController extends AbstractController
{
    #[Route('/login/register', name: 'app_login_register')]
    public function index(): Response
    {
        return $this->render('login_register/index.html.twig', [
            'controller_name' => 'LoginRegisterController',
        ]);
    }
}
