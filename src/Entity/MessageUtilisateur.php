<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MessageUtilisateurRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MessageUtilisateurRepository::class)]
class MessageUtilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["MessageUtilisateur"])]
    private ?int $id = null;

    #[ORM\Column(length: 500, nullable: false)]
    #[Groups(["MessageUtilisateur"])]
    private ?string $contenu = null;

    #[ORM\ManyToOne(inversedBy: 'messageUtilisateurs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["MessageUtilisateur"])]
    private ?User $utilisateur1 = null;

    #[ORM\ManyToOne(inversedBy: 'messageUtilisateurs')]
    #[Groups(["MessageUtilisateur"])]
    private ?User $utilisateur2 = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["MessageUtilisateur"])]
    private ?\DateTimeInterface $dateHeureEnvoi = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getUtilisateur1(): ?User
    {
        return $this->utilisateur1;
    }

    public function setUtilisateur1(?User $utilisateur1): static
    {
        $this->utilisateur1 = $utilisateur1;

        return $this;
    }

    public function getUtilisateur2(): ?User
    {
        return $this->utilisateur2;
    }

    public function setUtilisateur2(?User $utilisateur2): static
    {
        $this->utilisateur2 = $utilisateur2;

        return $this;
    }

    public function getDateHeureEnvoi(): ?\DateTimeInterface
    {
        return $this->dateHeureEnvoi;
    }

    public function setDateHeureEnvoi(\DateTimeInterface $dateHeureEnvoi): static
    {
        $this->dateHeureEnvoi = $dateHeureEnvoi;

        return $this;
    }
}
