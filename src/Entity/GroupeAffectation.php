<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\OrgaController;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeAffectationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 * collectionOperations={
*              "get","post"
*   },
 *  itemOperations={"get","delete"={"security"="is_granted('ROLE_GESTION_EQ')"},
 *                  "patch"={
 *                  "security"="is_granted('ROLE_GESTION_EQ')",
*                  "method"="PATCH",
*                  "path"="/groupe_affectations/{id}/addUsers",
*                  "controller"=OrgaController::class,
*                   "openapi_context"={
*                       "summary"="Permet d'ajouter des utilisateurs au Groupe"    
*                   },
*                  "denormalization_context"={"groups"={"gr_affect:addusers"}}
*              }
*   },
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
     * @Groups({"gr_affect:read","gr_affect:write","user:read"})
     * @Assert\NotBlank()
     */
    private $libelle;

    /**
     * @Groups({"gr_affect:read"})
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="groupeAffectations")
     */
    private $proprietaire;

    /**
     * @Groups({"gr_affect:read"})
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @Groups({"gr_affect:read","gr_affect:addusers"})
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="groupeAffected")
     */
    private $population;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $dateDernierAjout;

    public function __construct()
    {
        $this->propriétaire = new ArrayCollection();
        $this->population = new ArrayCollection();
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

    public function getProprietaire(): ?Service
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?Service $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

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

    /**
     * @return Collection<int, User>
     */
    public function getPopulation(): Collection
    {
        return $this->population;
    }

    public function addPopulation(User $population): self
    {
        if (!$this->population->contains($population)) {
            $this->population[] = $population;
        }

        return $this;
    }

    public function removePopulation(User $population): self
    {
        $this->population->removeElement($population);

        return $this;
    }

    public function getDateDernierAjout(): ?\DateTimeImmutable
    {
        return $this->dateDernierAjout;
    }

    public function setDateDernierAjout(?\DateTimeImmutable $dateDernierAjout): self
    {
        $this->dateDernierAjout = $dateDernierAjout;

        return $this;
    }
}
