<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nom;

    #[ORM\Column(type: 'text')]
    private string $description;

    

    #[ORM\Column(type: 'string', length: 100)]
    private string $pays;

    #[ORM\Column(type: 'boolean')]
    private bool $disponible = true;

    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private int $stock;

   // #[ORM\Column(type: 'string', length: 10, nullable: true)]
   // private ?string $etat = null;

   #[ORM\Column(type: 'string', length: 20)]
   private ?string $etat = null; 

   const ETAT_NOUVEAU = 'Nouveau';
   const ETAT_BONNE_OCCASION = 'Bonne occasion';

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeInterface $dateCreation;

   // #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    //private float $prix;
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $prix;


    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'produit', orphanRemoval: true, cascade: ['persist'])]
    private Collection $images;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'produit', orphanRemoval: true)]
    private Collection $commentaires;

   // #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'produits')]
   // private Collection $categories;
   #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'produits', cascade: ['persist'])]
   private ?Categorie $categorie = null;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->dateCreation = new \DateTime();
        $this->commentaires = new ArrayCollection();
    
    }

    // Getters et Setters (ceux déjà définis précédemment)

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

   

    public function getPays(): string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;
        return $this;
    }

    public function isDisponible(): bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): self
    {
        $this->disponible = $disponible;
        return $this;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;
        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

  

   public function setEtat(?string $etat): self
{
    if (!in_array($etat, [self::ETAT_NOUVEAU, self::ETAT_BONNE_OCCASION])) {
        throw new \InvalidArgumentException('L\'état doit être "Nouveau" ou "Bonne occasion".');
    }
    $this->etat = $etat;
    return $this;
}

    public function getDateCreation(): \DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getPrix(): float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProduit($this);
        }
        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // Définir le côté propriétaire à null (sauf si déjà changé)
            if ($image->getProduit() === $this) {
                $image->setProduit(null);
            }
        }
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setProduit($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getProduit() === $this) {
                $commentaire->setProduit(null);
            }
        }

        return $this;
    }
    public function getCategorie(): ?Categorie
    {
       return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
      $this->categorie = $categorie;

        return $this;
    }

    //public function getCategories(): Collection
    //{
    //    return $this->categories;
   // }

   // public function addCategorie(Categorie $categorie): self
   // {
     //   if (!$this->categories->contains($categorie)) {
    //        $this->categories->add($categorie);
    //    }
    //    return $this;
   // }

   // public function removeCategorie(Categorie $categorie): self
    //{
    //    $this->categories->removeElement($categorie);
    //    return $this;
    //}
}