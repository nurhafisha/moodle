<?php

namespace App\Entity;
use App\Entity\User;
use App\Repository\ActualiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActualiteRepository::class)]
class Actualite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_actualite", type: "integer")]
    private ?int $idActualite = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionAct = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datetimeAct = null;

    #[ORM\ManyToOne(inversedBy: 'actualites')]
    #[ORM\JoinColumn(name: 'code_ue', referencedColumnName: 'code_ue', onDelete: 'CASCADE', nullable: false)]
    private ?UE $codeUE = null;

    #[ORM\ManyToOne(targetEntity: Post::class)]
    #[ORM\JoinColumn(name: 'id_post', referencedColumnName: 'id_post', onDelete: "CASCADE", nullable: true)]
    private ?Post $post = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'actualites')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', onDelete: "CASCADE")]
    private ?User $user = null;


    public function __construct()
    {
        
    }

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

    public function getUser(): ?User
    {
        return $this->user;
    }
    
    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }


    public function getDatetimeAct(): ?\DateTimeInterface
    {
        return $this->datetimeAct;
    }

    public function setDatetimeAct(\DateTimeInterface $datetimeAct): static
    {
        $this->datetimeAct = $datetimeAct;

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
}
