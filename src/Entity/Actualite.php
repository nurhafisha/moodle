<?php

namespace App\Entity;

use App\Repository\ActualiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'actualites')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
            $user->addActualite($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeActualite($this);
        }

        return $this;
    }
}
