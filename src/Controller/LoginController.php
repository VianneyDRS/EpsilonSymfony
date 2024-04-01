<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


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
        return $this->render('login/index.html.twig', [
            'error' => '',
        ]);
    }
    #[Route('/', name: 'app_vide')]
    public function vide(): Response
    {
        return $this->render('login/vide.html.twig', [
            'error' => '',
        ]);
    }

    #[Route('/loginVerification', name: 'app_loginVerification')]
    public function login(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        
        $email = $request->request->get('mail');
        $password = $request->request->get('password');
        
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            return $this->render('login/index.html.twig', [
                'error' => 'Mot de passe ou mail incorrect',
            ]);
        }
        else {
            $userRepository = $entityManager->getRepository(User::class);
            $passwordVerify = $userRepository->findOneBy(['password' => $password]);
            $wololo = $passwordVerify ? $passwordVerify->getPassword() : null;
            if ($wololo === $password) {
                $session = $request->getSession();
                $session->start();
                $session->set('pseudo', $user->getPseudo());
                return $this->redirectToRoute('app_accueil');
            }
            else {
                return $this->render('login/index.html.twig', [
                    'error' => 'Mot de passe ou mail incorrect',
                ]);
            }
        }
    }
}