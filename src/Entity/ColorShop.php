<?php

namespace App\Entity;

use App\Repository\ColorShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColorShopRepository::class)]
class ColorShop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'color', targetEntity: TypeOfShop::class)]
    private Collection $typeOfShops;

    #[ORM\Column(length: 255)]
    private ?string $textColor = null;

    #[ORM\Column(length: 255)]
    private ?string $bgColor = null;

    public function __construct()
    {
        $this->typeOfShops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, TypeOfShop>
     */
    public function getTypeOfShops(): Collection
    {
        return $this->typeOfShops;
    }

    public function addTypeOfShop(TypeOfShop $typeOfShop): self
    {
        if (!$this->typeOfShops->contains($typeOfShop)) {
            $this->typeOfShops->add($typeOfShop);
            $typeOfShop->setColor($this);
        }

        return $this;
    }

    public function removeTypeOfShop(TypeOfShop $typeOfShop): self
    {
        if ($this->typeOfShops->removeElement($typeOfShop)) {
            // set the owning side to null (unless already changed)
            if ($typeOfShop->getColor() === $this) {
                $typeOfShop->setColor(null);
            }
        }

        return $this;
    }

    public function getTextColor(): ?string
    {
        return $this->textColor;
    }

    public function setTextColor(string $textColor): self
    {
        $this->textColor = $textColor;

        return $this;
    }

    public function getBgColor(): ?string
    {
        return $this->bgColor;
    }

    public function setBgColor(string $bgColor): self
    {
        $this->bgColor = $bgColor;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

}
