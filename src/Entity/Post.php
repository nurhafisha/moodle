<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idPost = null;

    #[ORM\Column(length: 255)]
    private ?string $titrePost = null;

    #[ORM\Column(type: Types::BLOB)]
    private $imageUE;

    #[ORM\Column(length: 255)]
    private ?string $typePost = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datetimePost = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionPost = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $depotPost = null;

    public function getId(): ?int
    {
        return $this->idPost;
    }

    public function getTitrePost(): ?string
    {
        return $this->titrePost;
    }

    public function setTitrePost(string $titrePost): static
    {
        $this->titrePost = $titrePost;

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

    public function getTypePost(): ?string
    {
        return $this->typePost;
    }

    public function setTypePost(string $typePost): static
    {
        $this->typePost = $typePost;

        return $this;
    }

    public function getDatetimePost(): ?\DateTimeInterface
    {
        return $this->datetimePost;
    }

    public function setDatetimePost(\DateTimeInterface $datetimePost): static
    {
        $this->datetimePost = $datetimePost;

        return $this;
    }

    public function getDescriptionPost(): ?string
    {
        return $this->descriptionPost;
    }

    public function setDescriptionPost(string $descriptionPost): static
    {
        $this->descriptionPost = $descriptionPost;

        return $this;
    }

    public function getDepotPost()
    {
        return $this->depotPost;
    }

    public function setDepotPost($depotPost): static
    {
        $this->depotPost = $depotPost;

        return $this;
    }
}
