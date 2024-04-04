<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class TravailController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/travail1', name: 'app_travail1')]
    public function travail1(Request $request): Response
    {
        $session = $request->getSession();
        if (!$session->has('adresseMail')) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('accueil/travail_1.html.twig');
    }

    #[Route('/travail2', name: 'app_travail2')]
    public function travail2(Request $request): Response
    {
        $session = $request->getSession();
        if (!$session->has('adresseMail')) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('accueil/travail_2.html.twig');
    }

    #[Route('/travail3', name: 'app_travail3')]
    public function travail3(Request $request): Response
    {
        $session = $request->getSession();
        if (!$session->has('adresseMail')) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('accueil/travail_3.html.twig');
    }
    

    #[Route('/upload', name: 'app_upload_file')]
    public function upload(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('adresseMail')) {
            return $this->redirectToRoute('app_login');
        }
        try {
            $file = $request->files->get('fichier');
        }
        catch (FileException $e) {
            return $this->render('accueil/uploadResult.html.twig',[
                'error' => 'Format invalide ou fichier manquant',
            ]);
        }
        
        try{
            $pseudo = $request->getSession()->get('pseudo');
        }
        catch (FileException $e) {
            return $this->render('accueil/uploadResult.html.twig',[
                'error' => 'Vous n\'êtes pas connecté',
            ]);
        }

        try{
            if ($file) {
                $tempPath = $file->getRealPath();
                $uploadDirectory = $this->getParameter('upload_directory').'/'.$pseudo;
                try{
                    if (!file_exists($uploadDirectory)) {
                        mkdir($uploadDirectory, 0777, true);
                    }
                }
                catch (FileException $e) {
                    return $this->render('accueil/uploadResult.html.twig',[
                        'error' => 'Problème de création du dossier',
                    ]);
                }
                try {
                    $destinationPath = $uploadDirectory . '/' . $file->getClientOriginalName();
                    move_uploaded_file($tempPath, $destinationPath);
                    return $this->render('accueil/uploadResult.html.twig',[
                        'error' => 'Réussite de l\'upload du fichier, vous le trouverez dans le dossier public/uploads/'.$pseudo.'/',
                    ]);
                }
                catch (FileException $e) {
                    return $this->render('accueil/uploadResult.html.twig',[
                        'error' => 'Problème de sauvgarde du dossier',
                    ]);
                }
            }
        }
        catch (FileException $e) {
            return $this->render('accueil/uploadResult.html.twig',[
                'error' => 'Problème avec le fichier',
            ]);
        }
    }
}
