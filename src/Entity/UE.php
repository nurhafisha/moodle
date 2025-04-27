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

    #[ORM\Column(type: 'blob', nullable: true)]
    private $imageUE;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true, name: 'image_mime_type_ue')]
    private $imageMimeTypeUE;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'liste_ue')]
    private Collection $users;

    /**
     * @var Collection<int, Post>
     */
    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'codeUE')]
    private Collection $posts;

    /**
     * @var Collection<int, Actualite>
     */
    #[ORM\OneToMany(targetEntity: Actualite::class, mappedBy: 'codeUE')]
    private Collection $actualites;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->actualites = new ArrayCollection();
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
    public function getImageMimeTypeUE(): ?string
    {
        return $this->imageMimeTypeUE;
    }

    public function setImageMimeTypeUE(?string $imageMimeTypeUE): static
    {
        $this->imageMimeTypeUE = $imageMimeTypeUE;
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

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setCodeUE($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getCodeUE() === $this) {
                $post->setCodeUE(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Actualite>
     */
    public function getActualites(): Collection
    {
        return $this->actualites;
    }

    public function addActualite(Actualite $actualite): static
    {
        if (!$this->actualites->contains($actualite)) {
            $this->actualites->add($actualite);
            $actualite->setCodeUE($this);
        }

        return $this;
    }

    public function removeActualite(Actualite $actualite): static
    {
        if ($this->actualites->removeElement($actualite)) {
            // set the owning side to null (unless already changed)
            if ($actualite->getCodeUE() === $this) {
                $actualite->setCodeUE(null);
            }
        }

        return $this;
    }
    public function getId(): ?string
    {
        return $this->codeUE; // Returns the codeUE as the ID
    }
}
