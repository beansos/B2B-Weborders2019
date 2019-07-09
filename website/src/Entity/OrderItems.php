<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderItemRepository")
 */
class OrderItems
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $sku;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min="0", max="500")
     */
    private $quantity;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(min="0", max="100000")
     */
    private $price;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Range(max="10000")
     */
    private $weight;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(min="0", max="100")
     */
    private $tax;

    /**
     * @ORM\ManyToOne(targetEntity="Orders", inversedBy="orderItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderId;

    /**
     * @ORM\ManyToOne(targetEntity="Products", inversedBy="orderItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productId;

    public function __construct(Orders $orderId = null)
    {
        $this->orderId = $orderId;
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function setTax(float $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getOrderId(): ?Orders
    {
        return $this->orderId;
    }

    public function setOrderId(?Orders $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getProductId(): ?Products
    {
        return $this->productId;
    }

    public function setProductId(?Products $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function __toString() {
        return (string) $this->id;
    }

}
