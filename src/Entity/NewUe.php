<?php

namespace App\Entity;

use App\Repository\NewUeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewUeRepository::class)]
class NewUe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code_ue = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_ue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_ue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeUe(): ?string
    {
        return $this->code_ue;
    }

    public function setCodeUe(string $code_ue): static
    {
        $this->code_ue = $code_ue;

        return $this;
    }

    public function getNomUe(): ?string
    {
        return $this->nom_ue;
    }

    public function setNomUe(string $nom_ue): static
    {
        $this->nom_ue = $nom_ue;

        return $this;
    }

    public function getImageUe(): ?string
    {
        return $this->image_ue;
    }

    public function setImageUe(?string $image_ue): static
    {
        $this->image_ue = $image_ue;

        return $this;
    }
}
