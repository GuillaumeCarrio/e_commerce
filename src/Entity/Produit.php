<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $designation = null;

    #[ORM\Column(nullable: true)]
    private ?float $prixUnite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $qteStock = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneCommande::class)]
    private Collection $ligneCommandes;

    #[ORM\ManyToOne(inversedBy: 'produit')]
    private ?Vendeur $vendeur = null;

    public function __construct()
    {
        $this->ligneCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPrixUnite(): ?float
    {
        return $this->prixUnite;
    }

    public function setPrixUnite(?float $prixUnite): static
    {
        $this->prixUnite = $prixUnite;

        return $this;
    }

    public function getQteStock(): ?string
    {
        return $this->qteStock;
    }

    public function setQteStock(?string $qteStock): static
    {
        $this->qteStock = $qteStock;

        return $this;
    }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): static
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes->add($ligneCommande);
            $ligneCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): static
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getProduit() === $this) {
                $ligneCommande->setProduit(null);
            }
        }

        return $this;
    }

    public function getVendeur(): ?Vendeur
    {
        return $this->vendeur;
    }

    public function setVendeur(?Vendeur $vendeur): static
    {
        $this->vendeur = $vendeur;

        return $this;
    }
}
