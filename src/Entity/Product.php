<?php
// src/Entity/Product.php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ApiResource(
    normalizationContext: ['groups' => ['product:read']],
    denormalizationContext: ['groups' => ['product:write']],
    security: "is_granted('ROLE_USER')", // Global access control: only users with ROLE_USER can access
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Patch(),
        new Put(),
        new Delete(),
    ]
)]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[Vich\Uploadable]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read', 'product:write'])]
    private ?string $name = null;

    #[Vich\UploadableField(mapping: 'product_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['product:read', 'product:write'])]
    private ?string $imageName = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[Groups(['product:read', 'product:write'])]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'products')]
    #[Groups(['product:read', 'product:write'])]
    private Collection $category;

    #[ORM\OneToMany(targetEntity: Price::class, mappedBy: 'product')]
    #[Groups(['product:read', 'product:write'])]
    private Collection $price;

    #[ORM\Column]
    #[Groups(['product:read', 'product:write'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['product:read', 'product:write'])]
    private ?\DateTimeImmutable $updatedAt = null;



    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->price = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->updatedAt = new \DateTimeImmutable('now');
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @return Collection<int, Price>
     */
    public function getPrice(): Collection
    {
        return $this->price;
    }

    public function addPrice(Price $price): static
    {
        if (!$this->price->contains($price)) {
            $this->price->add($price);
            $price->setProduct($this);
        }

        return $this;
    }

    public function removePrice(Price $price): static
    {
        if ($this->price->removeElement($price)) {
            if ($price->getProduct() === $this) {
                $price->setProduct(null);
            }
        }

        return $this;
    }
}
