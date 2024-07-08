<?php

// src/Entity/Sale.php

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['sale:read']],
    denormalizationContext: ['groups' => ['sale:write']],
)]
#[ORM\Entity(repositoryClass: SaleRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Sale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['sale:read', 'sale:write'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sales')]
    #[Groups(['sale:read', 'sale:write'])]
    private ?SalesChannel $canal = null;

    #[ORM\OneToMany(targetEntity: SalesProduct::class, mappedBy: 'sale', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['sale:read', 'sale:write'])]
    private Collection $salesProducts;

    #[ORM\Column]
    #[Groups(['sale:read', 'sale:write'])]
    private ?int $price = null;

    #[ORM\Column]
    #[Groups(['sale:read', 'sale:write'])]
    private ?int $benefit = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['sale:read', 'sale:write'])]
    private ?int $nbProduct = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['sale:read', 'sale:write'])]
    private ?int $nbClient = null;

    #[ORM\ManyToOne(inversedBy: 'sales')]
    #[Groups(['sale:read', 'sale:write'])]
    private ?User $user = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"], nullable: true)]
    #[Groups(['sale:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"], nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->salesProducts = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTimeImmutable();
        }
        if ($this->updatedAt === null) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        $this->nbProduct = $this->nbProduct ?? 0;
        $this->nbClient = $this->nbClient ?? 0;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCanal(): ?SalesChannel
    {
        return $this->canal;
    }

    public function setCanal(?SalesChannel $canal): static
    {
        $this->canal = $canal;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection<int, SalesProduct>
     */
    public function getSalesProducts(): Collection
    {
        return $this->salesProducts;
    }

    public function addSalesProduct(SalesProduct $salesProduct): static
    {
        if (!$this->salesProducts->contains($salesProduct)) {
            $this->salesProducts->add($salesProduct);
            $salesProduct->setSale($this);
        }

        return $this;
    }

    public function removeSalesProduct(SalesProduct $salesProduct): static
    {
        if ($this->salesProducts->removeElement($salesProduct)) {
            if ($salesProduct->getSale() === $this) {
                $salesProduct->setSale(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;
        return $this;
    }

    public function getBenefit(): ?int
    {
        return $this->benefit;
    }

    public function setBenefit(int $benefit): static
    {
        $this->benefit = $benefit;
        return $this;
    }

    public function getNbProduct(): ?int
    {
        return $this->nbProduct;
    }

    public function setNbProduct(int $nbProduct): static
    {
        $this->nbProduct = $nbProduct;
        return $this;
    }

    public function getNbClient(): ?int
    {
        return $this->nbClient;
    }

    public function setNbClient(int $nbClient): static
    {
        $this->nbClient = $nbClient;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }
}
