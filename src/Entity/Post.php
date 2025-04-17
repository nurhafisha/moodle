<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use DateTimeInterface;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idPost = null;

    #[ORM\Column(length: 255)]
    private ?string $titrePost = null;


    #[ORM\Column(length: 20, nullable: false)]
    private ?string $typePost = null;

    #[ORM\Column(name: "datetimePost", type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $datetimePost = null;

    #[ORM\Column(length: 2000, nullable: false)]
    private ?string $descriptionPost = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $depotPost = null;

    #[ORM\ManyToOne(targetEntity: UE::class, inversedBy: 'posts')]
    #[ORM\JoinColumn(name: 'code_ue', referencedColumnName: 'code_ue', onDelete: 'CASCADE', nullable: false)]
    private ?UE $codeUE = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $typeMessage = null;

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

    public function getCodeUE(): ?UE
    {
        return $this->codeUE;
    }

    public function setCodeUE(?UE $codeUE): static
    {
        $this->codeUE = $codeUE;

        return $this;
    }

    public function getTypeMessage(): ?string
    {
        return $this->typeMessage;
    }

    public function setTypeMessage(?string $typeMessage): static
    {
        $this->typeMessage = $typeMessage;

        return $this;
    }
}
