<?php
// src/Entity/Price.php

namespace App\Entity;

use App\Repository\PriceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ApiResource(
    normalizationContext: ['groups' => ['price:read']],
    denormalizationContext: ['groups' => ['price:write']],
    operations: [
        new GetCollection(),
        new Get(),
    ]
)]
#[ORM\Entity(repositoryClass: PriceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Price
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['price:read', 'product:read', 'product:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['price:read', 'product:read', 'product:write'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['price:read', 'product:read', 'product:write'])]
    private ?float $price = null;

    #[ORM\Column]
    #[Groups(['price:read', 'product:read', 'product:write'])]
    private ?float $benefit = null;

    #[ORM\Column]
    #[Groups(['price:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['price:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'prices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\OneToMany(targetEntity: SalesProduct::class, mappedBy: 'price')]
    private Collection $salesProducts;

    #[ORM\Column]
    #[Groups(['price:read', 'product:read', 'product:write'])]
    private ?float $ursaf = null;

    #[ORM\Column]
    #[Groups(['price:read', 'product:read', 'product:write'])]
    private ?float $expense = null;

    #[ORM\Column]
    #[Groups(['price:read', 'product:read', 'product:write'])]
    private ?float $commission = null;

    #[ORM\Column]
    #[Groups(['price:read', 'product:read', 'product:write'])]
    private ?float $time = null;

    public function __construct()
    {
        $this->salesProducts = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getBenefit(): ?float
    {
        return $this->benefit;
    }

    public function setBenefit(float $benefit): self
    {
        $this->benefit = $benefit;
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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;
        return $this;
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
            $salesProduct->setPrice($this);
        }

        return $this;
    }

    public function removeSalesProduct(SalesProduct $salesProduct): static
    {
        if ($this->salesProducts->removeElement($salesProduct)) {
            // set the owning side to null (unless already changed)
            if ($salesProduct->getPrice() === $this) {
                $salesProduct->setPrice(null);
            }
        }

        return $this;
    }

    public function getUrsaf(): ?float
    {
        return $this->ursaf;
    }

    public function setUrsaf(float $ursaf): static
    {
        $this->ursaf = $ursaf;

        return $this;
    }

    public function getExpense(): ?float
    {
        return $this->expense;
    }

    public function setExpense(float $expense): static
    {
        $this->expense = $expense;

        return $this;
    }

    public function getCommission(): ?float
    {
        return $this->commission;
    }

    public function setCommission(float $commission): static
    {
        $this->commission = $commission;

        return $this;
    }

    public function getTime(): ?float
    {
        return $this->time;
    }

    public function setTime(float $time): static
    {
        $this->time = $time;

        return $this;
    }
}
