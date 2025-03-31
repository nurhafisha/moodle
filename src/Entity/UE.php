<?php

namespace App\Entity;

use App\Repository\UERepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UERepository::class)]
class UE
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $idUE = null;

    #[ORM\Column(length: 255)]
    private ?string $codeUE = null;

    #[ORM\Column(length: 255)]
    private ?string $nomUE = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $imageUE;

    public function getIdUE(): ?int
    {
        return $this->idUE;
    }

    public function getCodeUE(): ?string
    {
        return $this->codeUE;
    }

    public function setCodeUE(string $codeUE): static
    {
        $this->codeUE = $codeUE;

        return $this;
    }

    public function getNomUE(): ?string
    {
        return $this->nomUE;
    }

    public function setNomUE(string $nomUE): static
    {
        $this->nomUE = $nomUE;

        return $this;
    }

    public function getImageUE()
    {
        return $this->imageUE;
    }

    public function setImageUE($imageUE): static
    {
        $this->imageUE = $imageUE;

        return $this;
    }
}
