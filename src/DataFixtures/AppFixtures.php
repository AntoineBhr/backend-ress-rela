<?php

namespace App\DataFixtures;

use DateTime;
use DateTimeZone;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Reponse;
use App\Entity\Categorie;
use App\Entity\Ressource;
use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use App\Entity\TypeRelation;
use App\Entity\EtatRessource;
use App\Entity\TypeRessource;
use App\Entity\MessageUtilisateur;
use App\Entity\RelationUtilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $userPasswordHasherInterface;

    // Injectez UserPasswordHasherInterface via le constructeur
    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }


    public function load(ObjectManager $manager): void
    {

        //Ajout catégorie
        $array = array(
            'Communication',
            'Cultures',
            'Développement personnel',
            'Intelligence émotionnelle',
            'Loisirs',
            'Monde professionnel',
            'Parentalité',
            'Qualité de vie',
            'Recherche de sens',
            'Santé physique',
            'Santé psychique',
            'Spiritualité',
            'Vie affective'
        );

        $categorieForRessource = null;
        foreach($array as $elem){
            $categorie = new Categorie();
            $categorie->setNom($elem);

            if($elem == 'Communication'){
                $categorieForRessource = $categorie;
            }
            $manager->persist($categorie);
        }


        //Ajout Type Relation
        $array = array(
            array('Soi', null),
            array('Conjoints', null),
            array('Famille', 'enfants / parents / fratrie'),
            array('Professionnelle', 'collègues, collaborateurs et managers'),
            array('Amis et communautés', null),
            array('Inconnus', null)
        );
        $typeRelationForRessource = null;
        foreach ($array as $values) {
            $typeRelation = new TypeRelation();
            $typeRelation->setNom($values[0]);
            $typeRelation->setCommentaire($values[1]);

            if($values[0] == 'Conjoints'){
                $typeRelationForRessource = $typeRelation;
            }

            $manager->persist($typeRelation);
        }

        //Ajout Type Ressource
        $array = array(
            'Activité / Jeu à réaliser',
            'Article',
            'Carte défi',
            'Cours au format PDF',
            'Exercice / Atelier',
            'Fiche de lecture',
            'Jeu en ligne',
            'Vidéo'
        );
    
        $typeRessourceForRessource = null;
        foreach ($array as $value) {
            $typeRessource = new TypeRessource();
            $typeRessource->setNom($value);
        
            if($value == 'Article'){
                $typeRessourceForRessource = $typeRessource;
            }
            $manager->persist($typeRessource);
        }



        $array = array(
            'Publiée',
            'En cours de traitement',
            'Refusée',
            'Archivée'
        );
        $etatRessourceForRessource = null;
        // Parcourir le tableau et assigner les valeurs aux objets EtatRessource
        foreach ($array as $value) {
            $etatRessource = new EtatRessource();
            $etatRessource->setNom($value);

            if($value == 'Publiée'){
                $etatRessourceForRessource = $etatRessource;
            }
            $manager->persist($etatRessource);
        }


        // $array = array(
        //     'Utilisateur',
        //     'Modérateur',
        //     'Administrateur',
        //     'Super-Administrateur'
        // );
        // // Parcourir le tableau et assigner les valeurs aux objets Role
        // $roleForUser = null;
        // foreach ($array as $value) {
            
        //     $role = new Role();
        //     $role->setNom($value);

        //     if($value == 'Utilisateur'){
        //         $roleForUser = $role;
        //     }
        //     $manager->persist($role);
        // }

        $dateTime = new DateTime('now', new DateTimeZone('Europe/Paris'));

        //Partie Utilisateur


        $utilisateur1 = new User();
        $utilisateur1->setPrenom('Michel')
            ->setNom('Patrick')
            ->setEmail('m.p@gmail.com')
            ->setPassword('123')
            ->setDepartement('Loiret')
            ->setDateCreation($dateTime)
            ->setEstActive(true)
            ->setApiToken(bin2hex(random_bytes(8)))

        ;
        $hashedPassword = $this->userPasswordHasherInterface->hashPassword($utilisateur1, $utilisateur1->getPassword());
        $utilisateur1->setPassword($hashedPassword);
        $manager->persist($utilisateur1);


        $utilisateur2 = new User();
        $utilisateur2->setPrenom('Laurent')
            ->setNom('Delaru')
            ->setEmail('l.d@gmail.com')
            ->setPassword('azerty')
            ->setDepartement('Ile de france')
            ->setDateCreation($dateTime)
            ->setEstActive(true)
            ->setApiToken(bin2hex(random_bytes(8)))

        ;
        $hashedPassword = $this->userPasswordHasherInterface->hashPassword($utilisateur2, $utilisateur2->getPassword());
        $utilisateur2->setPassword($hashedPassword);
        $manager->persist($utilisateur2);

        $utilisateur3 = new User();
        $utilisateur3->setPrenom('Bernard')
            ->setNom('Pavu')
            ->setEmail('b.p@gmail.com')
            ->setPassword('rootroot')
            ->setDepartement('Normandie')
            ->setDateCreation($dateTime)
            ->setEstActive(true)
            ->setApiToken(bin2hex(random_bytes(8)))

        ;
        $hashedPassword = $this->userPasswordHasherInterface->hashPassword($utilisateur3, $utilisateur3->getPassword());
        $utilisateur3->setPassword($hashedPassword);
        $manager->persist($utilisateur3);


        // //Partie Ressource

        $ressource1 = new Ressource();
        $ressource1->setTitre('Voici la première ressource du site')
            ->setDescription('Elle sera plutôt courte')
            ->setDatePublication($dateTime)
            ->setUtilisateur($utilisateur1)
            ->setCategorie($categorieForRessource)
            ->addTypeRelation($typeRelationForRessource)
            ->setEtatRessource($etatRessourceForRessource)
            ->setTypeRessource($typeRessourceForRessource)
        
        ;
        $manager->persist($ressource1);


        $ressource = new Ressource();
        $ressource->setTitre('Voici la deuxième ressource du site')
            ->setDescription('Elle sera plutôt courte elle aussi')
            ->setDatePublication($dateTime)
            ->setUtilisateur($utilisateur2)
            ->setCategorie($categorieForRessource)
            ->addTypeRelation($typeRelationForRessource)
            ->setEtatRessource($etatRessourceForRessource)
            ->setTypeRessource($typeRessourceForRessource)
        
        ;
        $manager->persist($ressource);


        $ressource = new Ressource();
        $ressource->setTitre('Voici la troisème ressource du site')
            ->setDescription('Elle sera plutôt courte elle aussi')
            ->setDatePublication($dateTime)
            ->setUtilisateur($utilisateur1)
            ->setCategorie($categorieForRessource)
            ->addTypeRelation($typeRelationForRessource)
            ->setEtatRessource($etatRessourceForRessource)
            ->setTypeRessource($typeRessourceForRessource)
        
        ;
        $manager->persist($ressource);


    



        // //Partie Commentaire

        $commentaire = new Commentaire();
        $commentaire->setContenu('En effet il est plutôt court')
            ->setDateCommentaire($dateTime)
            ->setRessource($ressource1)
            ->setUtilisateur($utilisateur1)
        ;
        $manager->persist($commentaire);


        $commentaire1 = new Commentaire();
        $commentaire1->setContenu('Qui m\'ajoute en amis ? :)')
            ->setDateCommentaire($dateTime)
            ->setRessource($ressource1)
            ->setUtilisateur($utilisateur2)
        ;
        $manager->persist($commentaire1);


        // Partie Reponse

        $reponse = new Reponse();
        $reponse->setContenu('Je t\'ai envoyé une demande')
            ->setDateReponse($dateTime)
            ->setCommentaire($commentaire1)
            ->setUtilisateur($utilisateur1)
        ;
        $manager->persist($reponse);



        // Partie RelationUtilisateur

        $relationUtilisateur = new RelationUtilisateur();
        $relationUtilisateur->setIdTypeRelation($typeRelationForRessource)
            ->setIdUtilisateur1($utilisateur1)
            ->setIdUtilisateur2($utilisateur2)
            ->setEstAccepte(true)

        ;
        $manager->persist($relationUtilisateur);

        $relationUtilisateur = new RelationUtilisateur();
        $relationUtilisateur->setIdTypeRelation($typeRelationForRessource)
            ->setIdUtilisateur1($utilisateur1)
            ->setIdUtilisateur2($utilisateur3)
            ->setEstAccepte(false)

        ;
        $manager->persist($relationUtilisateur);


        $relationUtilisateur = new RelationUtilisateur();
        $relationUtilisateur->setIdTypeRelation($typeRelationForRessource)
            ->setIdUtilisateur1($utilisateur2)
            ->setIdUtilisateur2($utilisateur3)
            ->setEstAccepte(true)

        ;
        $manager->persist($relationUtilisateur);


        //Partie MessageUtilisateur

        $messageUtilisateur = new MessageUtilisateur();
        $messageUtilisateur->setContenu('Salut, comment ça va ?')
            ->setDateHeureEnvoi($dateTime)
            ->setUtilisateur1($utilisateur1)
            ->setUtilisateur2($utilisateur2)
        ;
        $manager->persist($messageUtilisateur);


        $messageUtilisateur = new MessageUtilisateur();
        $messageUtilisateur->setContenu('tranquille et toi ?')
            ->setDateHeureEnvoi($dateTime)
            ->setUtilisateur1($utilisateur2)
            ->setUtilisateur2($utilisateur1)
        ;
        $manager->persist($messageUtilisateur);


        $manager->flush();
    }
}
