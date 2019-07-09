<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @Vich\Uploadable
 */
class Products
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(min="0", max="10000")
     */
    private $price;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Range(min="0", max="1000")
     */
    private $weight;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(min="0", max="100")
     */
    private $tax;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $sku;

    /**
     * @ORM\OneToMany(targetEntity="OrderItems", mappedBy="productId")
     */
    private $orderItems;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Range(min="0", max="50")
     */
    private $Batch;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @var String
     */
    private $path;


    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="path")
     * @var File
     */
    private $imageFile;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $category;


    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
        $this->orders = new ArrayCollection();
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

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getTax(): ?float
    {
        return $this->tax;
    }

    public function setTax(?float $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function getBatch(): ?float
    {
        return $this->Batch;
    }

    public function setBatch(?float $Batch): self
    {
        $this->Batch = $Batch;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path)
    {
        $this->path = $path;
    }

    public function setImageFile(File $path = null)
    {
        $this->imageFile = $path;
        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($path) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategory(): ?int
    {
        return $this->category;
    }

    public function setCategory(int $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|OrderItems[]
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItems $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems[] = $orderItem;
            $orderItem->setProductId($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItems $orderItem): self
    {
        if ($this->orderItems->contains($orderItem)) {
            $this->orderItems->removeElement($orderItem);
            // set the owning side to null (unless already changed)
            if ($orderItem->getProductId() === $this) {
                $orderItem->setProductId(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return (string) $this->name;
    }

}
