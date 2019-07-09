<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Orders
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(min="0", max="100000")
     */
    private $totalExcludingTax;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(min="0", max="200000")
     */
    private $totalTax;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Range(max="10000")
     */
    private $totalWeight;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(max="8")
     */
    private $frequency;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Range(min="now")
     */
    private $deliveryDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userId;

    /**
     * @ORM\OneToMany(targetEntity="OrderItems", mappedBy="orderId", cascade="All", orphanRemoval=true)
     */
    public $orderItems;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id_id;


    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
        $this->setCreationDate(new \DateTime());
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalExcludingTax(): ?float
    {
        return $this->totalExcludingTax;
    }

    public function setTotalExcludingTax(float $totalExcludingTax): self
    {
        $this->totalExcludingTax = $totalExcludingTax;

        return $this;
    }

    public function getTotalTax(): ?float
    {
        return $this->totalTax;
    }

    public function setTotalTax(float $totalTax): self
    {
        $this->totalTax = $totalTax;

        return $this;
    }

    public function getTotalWeight(): ?float
    {
        return $this->totalWeight;
    }

    public function setTotalWeight(?float $totalWeight): self
    {
        $this->totalWeight = $totalWeight;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {

        $this->creationDate = $creationDate;

        return $this;
    }

    public function getFrequency(): ?int
    {
        return $this->frequency;
    }

    public function setFrequency(?int $frequency): self
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUserId(): ?Users
    {
        return $this->userId;
    }

    public function setUserId(?Users $userId): self
    {
        $this->userId = $userId;

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
            $orderItem->setOrderId($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItems $orderItem): self
    {
        if ($this->orderItems->contains($orderItem)) {
            $this->orderItems->removeElement($orderItem);
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrderId() === $this) {
                $orderItem->setOrderId(null);
            }
        }

        return $this;
    }

    public function getUserIdId(): ?int
    {
        return $this->user_id_id;
    }

    public function setUserIdId(int $user_id_id): self
    {
        $this->user_id_id = $user_id_id;

        return $this;
    }

    public function __toString() {
        return (string) $this->id;
    }

}
