<?php

namespace App\Entity;

use App\Repository\AuteursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('auteur')]
#[ORM\Entity(repositoryClass: AuteursRepository::class)]
class Auteurs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 63)]
    #[Assert\NotBlank()]
    private string $auteur;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bio = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private \DateTimeImmutable $dateModif;

    #[ORM\OneToMany(mappedBy: 'auteurs', targetEntity: Citations::class)]
    private Collection $citations;
    

    public function __construct()
    {
        $this->dateModif = new \DateTimeImmutable();
        $this->citations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getDateModif(): ?\DateTimeImmutable
    {
        return $this->dateModif;
    }

    public function setDateModif(\DateTimeImmutable $dateModif): static
    {
        $this->dateModif = $dateModif;

        return $this;
    }

    /**
     * @return Collection<int, Citations>
     */
    public function getCitations(): Collection
    {
        return $this->citations;
    }

    public function addCitation(Citations $citation): static
    {
        if (!$this->citations->contains($citation)) {
            $this->citations->add($citation);
            $citation->setAuteurs($this);
        }

        return $this;
    }

    public function removeCitation(Citations $citation): static
    {
        if ($this->citations->removeElement($citation)) {
            if ($citation->getAuteurs() === $this) {
                $citation->setAuteurs(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->auteur;
    }
}
