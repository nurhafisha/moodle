<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;


#[ORM\Entity(repositoryClass: UserRepository::class)]

#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: '
Il existe déjà un compte avec cet email')]



class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Nom ne peut pas être vide.')]
    private ?string $nomUser = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Prenom ne peut pas être vide.')]
    private ?string $prenomUser = null;

    /**
     * @var Collection<int, UE>
     */
    #[ORM\ManyToMany(targetEntity: UE::class, inversedBy: 'users')]
    #[ORM\JoinTable(
        name: 'user_ue',
        joinColumns: [
            new ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', onDelete: 'CASCADE')
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: 'code_ue', referencedColumnName: 'code_ue', onDelete: 'CASCADE')
        ]
    )]
    private Collection $liste_ue;

    public function __construct()
    {
        $this->liste_ue = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER

        $roles[] = 'ROLE_USER';

        // $roles[] = 'ROLE_GUEST';


        return array_unique($roles);
        // return $this->roles;
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomUser(): ?string
    {
        return $this->nomUser;
    }

    public function setNomUser(string $nomUser): self
    {
        $this->nomUser = $nomUser;

        return $this;
    }

    public function getPrenomUser(): ?string
    {
        return $this->prenomUser;
    }

    public function setPrenomUser(string $prenomUser): static
    {
        $this->prenomUser = $prenomUser;

        return $this;
    }


// for images:
    #[ORM\Column(type: 'blob', nullable: true)]
    private $imageData;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $imageMimeType;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

    public function getImageData()
    {
        if (is_resource($this->imageData)) {
            return stream_get_contents($this->imageData);
        }
        return $this->imageData;
    }

    public function setImageData($imageData): self
    {
        $this->imageData = $imageData;
        return $this;
    }

    public function getImageMimeType(): ?string
    {
        return $this->imageMimeType;
    }

    public function setImageMimeType(?string $imageMimeType): self
    {
        $this->imageMimeType = $imageMimeType;
        return $this;
    }

    /**
     * @return Collection<int, UE>
     */

    public function getListeUe(): Collection
    {
        return $this->liste_ue;
    }

    public function addListeUe(UE $listeUe): static
    {
        if (!$this->liste_ue->contains($listeUe)) {
            $this->liste_ue->add($listeUe);
        }

        return $this;
    }

    public function removeListeUe(UE $listeUe): static
    {
        $this->liste_ue->removeElement($listeUe);

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }
}
