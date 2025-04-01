<?php

namespace App\Entity;

use App\Repository\ActualiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActualiteRepository::class)]
class Actualite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idActualite = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionAct = null;

    public function getId(): ?int
    {
        return $this->idActualite;
    }

    public function getDescriptionAct(): ?string
    {
        return $this->descriptionAct;
    }

    public function setDescriptionAct(string $descriptionAct): static
    {
        $this->descriptionAct = $descriptionAct;

        return $this;
    }
}
