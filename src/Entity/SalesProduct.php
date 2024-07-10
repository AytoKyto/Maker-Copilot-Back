<?php

namespace App\Entity;

use App\Repository\SalesProductRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    paginationEnabled: false,
    normalizationContext: ['groups' => ['sale:read']],
    denormalizationContext: ['groups' => ['sale:write']],
)]
#[ORM\Entity(repositoryClass: SalesProductRepository::class)]
class SalesProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['sale:read', 'sale:write'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'salesProducts')]
    private ?Sale $sale = null;

    #[Groups(['sale:read', 'sale:write'])]
    #[ORM\ManyToOne(inversedBy: 'salesProducts')]
    private ?Product $product = null;

    #[Groups(['sale:read', 'sale:write'])]
    #[ORM\ManyToOne(inversedBy: 'salesProducts')]
    private ?Price $price = null;

    #[Groups(['sale:read', 'sale:write'])]
    #[ORM\ManyToOne(inversedBy: 'salesProducts')]
    private ?Client $client = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"], nullable: true)]
    #[Groups(['sale:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"], nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSale(): ?Sale
    {
        return $this->sale;
    }

    public function setSale(?Sale $sale): static
    {
        $this->sale = $sale;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getPrice(): ?Price
    {
        return $this->price;
    }

    public function setPrice(?Price $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

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

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }
}
