<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeAffectationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 * collectionOperations={"get","post"},
 *  itemOperations={"get"},
 *  normalizationContext={"groups"={"gr_affect:read"}},
 *  denormalizationContext={"groups"={"gr_affect:write"}},
 * )
 * @ORM\Entity(repositoryClass=GroupeAffectationRepository::class)
 * @UniqueEntity(fields={"libelle"})
 */
class GroupeAffectation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"gr_affect:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"gr_affect:read","gr_affect:write"})
     * @Assert\NotBlank()
     */
    private $libelle;

    /**
     * @Groups({"gr_affect:read"})
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="groupeAffectations")
     */
    private $propriétaire;

    /**
     * @Groups({"gr_affect:read"})
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    public function __construct()
    {
        $this->propriétaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPropriétaire(): Collection
    {
        return $this->propriétaire;
    }

    public function addPropriTaire(User $propriTaire): self
    {
        if (!$this->propriétaire->contains($propriTaire)) {
            $this->propriétaire[] = $propriTaire;
        }

        return $this;
    }

    public function removePropriTaire(User $propriTaire): self
    {
        $this->propriétaire->removeElement($propriTaire);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
