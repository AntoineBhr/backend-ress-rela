<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


    #[Route('/api/me', name: 'api_user_me')]
    #[IsGranted('ROLE_USER')]
    public function me(SerializerInterface $serializer)
    {
        $user = $this->getUser();
        
        // Sérialiser l'utilisateur en utilisant le groupe "Utilisateur"
        $jsonUser = $serializer->serialize($user, 'json', ['groups' => ['CheckUser']]);

        return $this->json(json_decode($jsonUser), 200);
    }
}
