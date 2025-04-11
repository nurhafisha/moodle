<?php

namespace App\Entity;

use App\Repository\UERepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UERepository::class)]
class UE
{
    #[ORM\Id]
    #[ORM\Column(name: "code_ue", type: 'string', length: 4)]
    private ?string $codeUE = null;

    #[ORM\Column(length: 255)]
    private ?string $nomUE = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $imageUE;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'liste_ue')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addListeUe($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeListeUe($this);
        }

        return $this;
    }
}
