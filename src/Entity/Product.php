<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column]
    private ?bool $Best = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Commmantaire::class)]
    private Collection $commmantaires;

    public function __construct()
    {
        $this->commmantaires = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function isBest(): ?bool
    {
        return $this->Best;
    }

    public function setBest(bool $Best): self
    {
        $this->Best = $Best;

        return $this;
    }

    /**
     * @return Collection<int, Commmantaire>
     */
    public function getCommmantaires(): Collection
    {
        return $this->commmantaires;
    }

    public function addCommmantaire(Commmantaire $commmantaire): self
    {
        if (!$this->commmantaires->contains($commmantaire)) {
            $this->commmantaires->add($commmantaire);
            $commmantaire->setProduit($this);
        }

        return $this;
    }

    public function removeCommmantaire(Commmantaire $commmantaire): self
    {
        if ($this->commmantaires->removeElement($commmantaire)) {
            // set the owning side to null (unless already changed)
            if ($commmantaire->getProduit() === $this) {
                $commmantaire->setProduit(null);
            }
        }

        return $this;
    }
}
