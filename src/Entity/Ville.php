<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $cp = null;

    #[ORM\Column(length: 255)]
    private ?string $nomDp = null;

    #[ORM\Column]
    private ?int $numDp = null;

    #[ORM\Column(length: 255)]
    private ?string $nomR = null;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: Etablissement::class)]
    private Collection $etablissements;

    public function __construct()
    {
        $this->etablissements = new ArrayCollection();
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

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getNomDp(): ?string
    {
        return $this->nomDp;
    }

    public function setNomDp(string $nomDp): self
    {
        $this->nomDp = $nomDp;

        return $this;
    }

    public function getNumDp(): ?int
    {
        return $this->numDp;
    }

    public function setNumDp(int $numDp): self
    {
        $this->numDp = $numDp;

        return $this;
    }

    public function getNomR(): ?string
    {
        return $this->nomR;
    }

    public function setNomR(string $nomR): self
    {
        $this->nomR = $nomR;

        return $this;
    }

    /**
     * @return Collection<int, Etablissement>
     */
    public function getEtablissements(): Collection
    {
        return $this->etablissements;
    }

    public function addEtablissement(Etablissement $etablissement): self
    {
        if (!$this->etablissements->contains($etablissement)) {
            $this->etablissements->add($etablissement);
            $etablissement->setVille($this);
        }

        return $this;
    }

    public function removeEtablissement(Etablissement $etablissement): self
    {
        if ($this->etablissements->removeElement($etablissement)) {
            // set the owning side to null (unless already changed)
            if ($etablissement->getVille() === $this) {
                $etablissement->setVille(null);
            }
        }

        return $this;
    }
}
