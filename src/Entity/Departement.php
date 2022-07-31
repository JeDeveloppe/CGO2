<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 4)]
    private ?string $departementCode = null;

    #[ORM\Column(length: 255)]
    private ?string $departementNom = null;

    #[ORM\Column(length: 255)]
    private ?string $departementNomUppercase = null;

    #[ORM\Column(length: 255)]
    private ?string $departementSlug = null;

    #[ORM\Column(length: 255)]
    private ?string $departementNomSoundex = null;

    #[ORM\ManyToMany(targetEntity: Cgo::class, mappedBy: 'departements')]
    private Collection $cgo;

    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: Ville::class)]
    private Collection $villes;

    public function __construct()
    {
        $this->cgo = new ArrayCollection();
        $this->villes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartementCode(): ?string
    {
        return $this->departementCode;
    }

    public function setDepartementCode(string $departementCode): self
    {
        $this->departementCode = $departementCode;

        return $this;
    }

    public function getDepartementNom(): ?string
    {
        return $this->departementNom;
    }

    public function setDepartementNom(string $departementNom): self
    {
        $this->departementNom = $departementNom;

        return $this;
    }

    public function getDepartementNomUppercase(): ?string
    {
        return $this->departementNomUppercase;
    }

    public function setDepartementNomUppercase(string $departementNomUppercase): self
    {
        $this->departementNomUppercase = $departementNomUppercase;

        return $this;
    }

    public function getDepartementSlug(): ?string
    {
        return $this->departementSlug;
    }

    public function setDepartementSlug(string $departementSlug): self
    {
        $this->departementSlug = $departementSlug;

        return $this;
    }

    public function getDepartementNomSoundex(): ?string
    {
        return $this->departementNomSoundex;
    }

    public function setDepartementNomSoundex(string $departementNomSoundex): self
    {
        $this->departementNomSoundex = $departementNomSoundex;

        return $this;
    }

    public function getCgo(): ?Cgo
    {
        return $this->cgo;
    }

    public function setCgo(?Cgo $cgo): self
    {
        $this->cgo = $cgo;

        return $this;
    }

    public function addCgo(Cgo $cgo): self
    {
        if (!$this->cgo->contains($cgo)) {
            $this->cgo->add($cgo);
        }

        return $this;
    }

    public function removeCgo(Cgo $cgo): self
    {
        $this->cgo->removeElement($cgo);

        return $this;
    }

    /**
     * @return Collection<int, Ville>
     */
    public function getVilles(): Collection
    {
        return $this->villes;
    }

    public function addVille(Ville $ville): self
    {
        if (!$this->villes->contains($ville)) {
            $this->villes->add($ville);
            $ville->setDepartement($this);
        }

        return $this;
    }

    public function removeVille(Ville $ville): self
    {
        if ($this->villes->removeElement($ville)) {
            // set the owning side to null (unless already changed)
            if ($ville->getDepartement() === $this) {
                $ville->setDepartement(null);
            }
        }

        return $this;
    }
}
