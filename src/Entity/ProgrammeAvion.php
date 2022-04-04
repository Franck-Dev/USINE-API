<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProgrammeAvionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *  collectionOperations={"get","post"},
 *  itemOperations={"get"},
 *  normalizationContext={"groups"={"progAv:read"}},
 *  denormalizationContext={"groups"={"progAv:write"}},
 * )
 * @ORM\Entity(repositoryClass=ProgrammeAvionRepository::class)
 * @UniqueEntity(fields={"designation"})
 * @UniqueEntity(fields={"code"})
 */
class ProgrammeAvion
{
    /**
     * @Groups({"progAv:read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"progAv:read","progAv:write"})
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $designation;

    /**
     * @Groups({"progAv:read","progAv:write"})
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $code;

    /**
     * @Groups({"progAv:read","progAv:write"})
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $client;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="programmeAvion")
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

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): self
    {
        $this->client = $client;

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
            $user->addProgrammeAvion($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeProgrammeAvion($this);
        }

        return $this;
    } 
}
