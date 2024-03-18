<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;


class LoginController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/login', name: 'app_login')]
    public function index(): Response
    {
        return $this->render('login/index.html.twig');
    }

    #[Route('/verification', name: 'app_loginVerification')]
    public function login(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = new Session();
        
        $email = $request->request->get('mail');
        $password = $request->request->get('password');
        
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            return $this->render('login/index.html.twig', [
                'error' => 'Invalid email or password',
            ]);
        }
        else {
            if (password_verify($password, $user->getPassword())) {
                $session->set('user', $user);
                return $this->redirectToRoute('app_accueil');
            }
            else {
                return $this->render('login/index.html.twig', [
                    'error' => 'Invalid email or password',
                ]);
            }
        }
    }
}