<?php

namespace App\Controller;

use DateTime;
use DateTimeZone;
use App\Entity\Utilisateur;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/utilisateur')]
class UtilisateurController extends AbstractController
{
    #[Route('/', name: 'app_utilisateur_index', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository, SerializerInterface $serializer): Response
    {
        $users = $utilisateurRepository->findAll();
        $jsonUsers = $serializer->serialize($users, 'json', ['groups' => 'Utilisateur']);
        return new JsonResponse($jsonUsers, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'app_utilisateur_show', methods: ['GET'])]
    public function show(Utilisateur $utilisateur, SerializerInterface $serializer): Response
    {
        $jsonUser = $serializer->serialize($utilisateur, 'json', ['groups' => 'Utilisateur']);
        return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
    }

    #[Route('/user/CheckUser', name: 'app_utilisateur_check_user', methods: ['POST'])]
    public function checkUser(Request $request, UtilisateurRepository $utilisateurRepository, SerializerInterface $serializer): Response
    {
        $login = $request->get('login');
        $password = $request->get('password');

        // Hachage du mot de passe saisi par l'utilisateur avec SHA-256
        $hashedPassword = hash('sha256', $password);

        // Recherche de l'utilisateur avec l'adresse email et le mot de passe haché
        $user = $utilisateurRepository->findOneBy(['mail' => $login, 'motDePasse' => $hashedPassword]);

        $jsonUsers = $serializer->serialize($user, 'json', ['groups' => 'CheckUser']);
        return new JsonResponse($jsonUsers, Response::HTTP_OK, [], true);
    }

    #[Route('/user/SearchUser', name: 'app_utilisateur_search_user', methods: ['POST'])]
    public function getSearchUser(Request $request, UtilisateurRepository $utilisateurRepository, SerializerInterface $serializer): Response
    {
        $valueUser = $request->getContent();
        $data = json_decode($valueUser, true);

        if (empty($data['nom']) && empty($data['prenom'])) {
            $users = array();
        } else {
            $users = $utilisateurRepository->getListSearchUser($data['nom'], $data['prenom']);
        }

        $jsonUsers = $serializer->serialize($users, 'json');
        return new JsonResponse($jsonUsers, Response::HTTP_OK, [], true);
    }

    #[Route('/', name: 'app_utilisateur_new', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator, RoleRepository $roleRepository): JsonResponse
    {
        $utilisateur = $serializer->deserialize($request->getContent(), Utilisateur::class, 'json');

        $content = $request->toArray();
        $idRole = $content['id_role'] ?? 1;
        $dateTime = new DateTime('now', new DateTimeZone('Europe/Paris'));

        $utilisateur->setRole($roleRepository->find($idRole));
        $utilisateur->setDateCreation($dateTime);
        $utilisateur->setEstActive(true);

        // Hachage du mot de passe avant de le stocker
        $hashedPassword = hash('sha256', $utilisateur->getMotDePasse());
        $utilisateur->setMotDePasse($hashedPassword);

        $em->persist($utilisateur);
        $em->flush();

        $jsonBook = $serializer->serialize($utilisateur, 'json', ['groups' => 'Utilisateur']);
        $location = $urlGenerator->generate('app_utilisateur_show', ['id' => $utilisateur->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        return new JsonResponse($jsonBook, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/{id}', name: 'app_utilisateur_edit', methods: ['PUT'])]
    public function edit(Request $request, SerializerInterface $serializer, Utilisateur $currentUtilisateur, EntityManagerInterface $em, RoleRepository $authorRepository): JsonResponse
    {
        $psw = $currentUtilisateur->getMotDePasse();
        $updatedUtilisateur = $serializer->deserialize(
            $request->getContent(),
            Utilisateur::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $currentUtilisateur]
        );
        $content = $request->toArray();
        $idRole = $content['id_role'] ?? 1;
        $updatedUtilisateur->setRole($authorRepository->find($idRole));

        // Hachage du nouveau mot de passe si présent
        if (isset($content['motDePasse']) && !empty($content['motDePasse'])) {
            $hashedPassword = hash('sha256', $content['motDePasse']);
            $updatedUtilisateur->setMotDePasse($hashedPassword);
        } else {
            $updatedUtilisateur->setMotDePasse($psw);
        }

        $em->persist($updatedUtilisateur);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    #[Route('/{id}', name: 'app_utilisateur_delete', methods: ['DELETE'])]
    public function delete(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($utilisateur);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
