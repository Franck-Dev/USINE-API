<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UsineRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 * collectionOperations={"get","post"},
 *  itemOperations={"get"},
 *  normalizationContext={"groups"={"usine:read"}},
 *  denormalizationContext={"groups"={"usine:write"}},
 * )
 * @ORM\Entity(repositoryClass=UsineRepository::class)
 * @UniqueEntity(fields={"libelle"})
 */
class Usine
{
    /**
     * @Groups({"usine:read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"usine:read","usine:write"})
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @Groups({"usine:read"})
     * @ORM\OneToMany(targetEntity=Division::class, mappedBy="Entreprise")
     */
    private $divisions;

    public function __construct()
    {
        $this->divisions = new ArrayCollection();
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
     * @return Collection<int, Division>
     */
    public function getDivisions(): Collection
    {
        return $this->divisions;
    }

    public function addDivision(Division $division): self
    {
        if (!$this->divisions->contains($division)) {
            $this->divisions[] = $division;
            $division->setEntreprise($this);
        }

        return $this;
    }

    public function removeDivision(Division $division): self
    {
        if ($this->divisions->removeElement($division)) {
            // set the owning side to null (unless already changed)
            if ($division->getEntreprise() === $this) {
                $division->setEntreprise(null);
            }
        }

        return $this;
    }
}
