<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name:'orders')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'order_id', length: 180, unique: true)]
    private ?int $orderId = null;

    #[ORM\Column(name: 'client_id', length: 180, unique: true)]
    private int $clientId;

    #[ORM\Column(length: 255, unique: true)]
    private ?int $products = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?int $sum = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $status = null;

    public function __construct(
        int $orderId,
        int $clientId,
        int $products,
        string $country,
        int $sum,
        string $status
    ) {
        $this->orderId = $orderId;
        $this->clientId = $clientId;
        $this->products = $products;
        $this->country = $country;
        $this->sum = $sum;
        $this->status = $status;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getProducts(): ?int
    {
        return $this->products;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getSum(): ?int
    {
        return $this->sum;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function update(
        int $orderId,
        int $products,
        string $country,
        int $sum,
        string $status
    ): void {
        $this->orderId = $orderId;
        $this->products = $products;
        $this->country = $country;
        $this->sum = $sum;
        $this->status = $status;
    }
}
