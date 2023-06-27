<?php

namespace App\Entity;

use App\Repository\CitationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CitationsRepository::class)]
class Citations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 127)]
    #[Assert\NotBlank()]
    private string $citation;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $explication = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private \DateTimeImmutable $date_modif;

    #[ORM\ManyToOne(inversedBy: 'citations')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Auteurs $auteurs = null;


    public function __construct()
    {
        $this->date_modif = new \DateTimeImmutable();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCitation(): ?string
    {
        return $this->citation;
    }

    public function setCitation(string $citation): static
    {
        $this->citation = $citation;

        return $this;
    }

    public function getExplication(): ?string
    {
        return $this->explication;
    }

    public function setExplication(?string $explication): static
    {
        $this->explication = $explication;

        return $this;
    }

    public function getDateModif(): ?\DateTimeImmutable
    {
        return $this->date_modif;
    }

    public function setDateModif(\DateTimeImmutable $date_modif): static
    {
        $this->date_modif = $date_modif;

        return $this;
    }

    public function getAuteurs(): ?Auteurs
    {
        return $this->auteurs;
    }

    public function setAuteurs(?Auteurs $auteurs): static
    {
        $this->auteurs = $auteurs;

        return $this;
    }
}
