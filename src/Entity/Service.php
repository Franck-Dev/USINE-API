<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *  collectionOperations={"get","post"},
 *  itemOperations={"get"},
 *  normalizationContext={"groups"={"serv:read"}},
 *  denormalizationContext={"groups"={"serv:write"}},
 * )
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 * @UniqueEntity(fields={"nom"})
 */
class Service
{
    /**
     * @Groups({"serv:read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"serv:read","serv:write"})
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @Groups({"serv:read"})
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="service")
     */
    private $users;

    
    /**
     * @Groups({"user:read","userGroups:affect"})
     * @ORM\OneToMany(targetEntity=GroupeAffectation::class, mappedBy="proprietaire")
     */
    private $groupeAffectations;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->groupeAffectations = new ArrayCollection();
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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setService($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getService() === $this) {
                $user->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GroupeAffectation>
     */
    public function getGroupeAffectations(): Collection
    {
        return $this->groupeAffectations;
    }

    public function addGroupeAffectation(GroupeAffectation $groupeAffectation): self
    {
        if (!$this->users->contains($groupeAffectation)) {
            $this->users[] = $groupeAffectation;
            $groupeAffectation->setProprietaire($this);
        }

        return $this;
    }

    public function removeGroupeAffectation(GroupeAffectation $groupeAffectation): self
    {
        if ($this->users->removeElement($groupeAffectation)) {
            // set the owning side to null (unless already changed)
            if ($groupeAffectation->getProprietaire() === $this) {
                $groupeAffectation->setProprietaire(null);
            }
        }

        return $this;
    }
}
