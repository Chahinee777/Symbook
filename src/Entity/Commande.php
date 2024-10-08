<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'date_commande')]
    private ?User $id_user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Dt_commande = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etat = null;

    #[ORM\OneToMany(targetEntity: Lignecommandes::class, mappedBy: 'commande',cascade: ['persist'])]
    private Collection $Lignecommande;

    public function __construct()
    {
        $this->Lignecommande = new ArrayCollection();
    }

 
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getDtCommande(): ?\DateTimeInterface
    {
        return $this->Dt_commande;
    }

    public function setDtCommande(?\DateTimeInterface $Dt_commande): static
    {
        $this->Dt_commande = $Dt_commande;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

   
   
   
    public function addLignecommande(Lignecommandes $lignecommande): self
    {
        if (!$this->Lignecommande->contains($lignecommande)) {
            $this->Lignecommande[] = $lignecommande;
            $lignecommande->setCommande($this);
        }

        return $this;
    }
    public function getTotal(): float
{
    $total = 0;

    foreach ($this->Lignecommande as $ligne) {
        $total += $ligne->getQuantite() * $ligne->getLivre()->getPrix();
    }

    return $total;
}

   
   // public function addLignecommande(Lignecommandes $lignecommandes): self
    //{
      //  if (!$this->Lignecommande->contains($lignecommandes)) {
          //  $this->Lignecommande[] = $lignecommandes;
          //  $lignecommandes->setOrders($this);
       // }

      //  return $this;
  //  }

    /**
     * @return Collection<int, Lignecommandes>
     */
    public function getLignecommande(): Collection
    {
        return $this->Lignecommande;
    }

    public function removeLignecommande(Lignecommandes $lignecommande): static
    {
        if ($this->Lignecommande->removeElement($lignecommande)) {
            // set the owning side to null (unless already changed)
            if ($lignecommande->getCommande() === $this) {
                $lignecommande->setCommande(null);
            }
        }

        return $this;
    }
}
