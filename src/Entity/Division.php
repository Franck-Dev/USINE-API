<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DivisionRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 * collectionOperations={"get","post"},
 *  itemOperations={"get"},
 *  normalizationContext={"groups"={"div:read"}},
 *  denormalizationContext={"groups"={"div:write"}},
 * )
 * @ORM\Entity(repositoryClass=DivisionRepository::class)
 * @UniqueEntity(fields={"nom"})
 */
class Division
{
    /**
     * @Groups({"div:read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"div:read","div:write","usine:read","user:read"})
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @Groups({"div:read","div:write"})
     * @ORM\ManyToOne(targetEntity=Usine::class, inversedBy="divisions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Entreprise;

    /**
     * @Groups({"div:read"})
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="unite")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEntreprise(): ?Usine
    {
        return $this->Entreprise;
    }

    public function setEntreprise(?Usine $Entreprise): self
    {
        $this->Entreprise = $Entreprise;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setUnite($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getUnite() === $this) {
                $user->setUnite(null);
            }
        }

        return $this;
    }
}
