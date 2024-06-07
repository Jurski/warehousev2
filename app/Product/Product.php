<?php

namespace App\Product;

use Carbon\Carbon;
use JsonSerializable;
use Ramsey\Uuid\Uuid;

class Product implements JsonSerializable
{
    private string $id;
    private string $name;
    private int $amount;
    private ?float $price;
    private Carbon $createdAt;
    private ?Carbon $lastUpdatedAt;
    private ?Carbon $qualityExpirationDate;


    public function __construct(
        string  $name,
        int     $amount,
        ?float  $price,
        ?Carbon $qualityExpirationDate = null,
        ?Carbon $createdAt = null,
        ?Carbon $lastUpdatedAt = null,
        ?string $id = null
    )
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
        $this->name = $name;
        $this->amount = $amount;
        $this->price = $price;
        $this->qualityExpirationDate = $qualityExpirationDate;
        $this->createdAt = $createdAt ? Carbon::parse($createdAt) : Carbon::now('UTC');
        $this->lastUpdatedAt = $lastUpdatedAt ? Carbon::parse($lastUpdatedAt) : null;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function getLastUpdatedAt(): ?Carbon
    {
        return $this->lastUpdatedAt;
    }

    public function getQualityExpirationDate(): ?Carbon
    {
        return $this->qualityExpirationDate;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function setLastUpdatedAt(Carbon $lastUpdatedAt): void
    {
        $this->lastUpdatedAt = $lastUpdatedAt;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'amount' => $this->amount,
            'price' => $this->price,
            'qualityExpirationDate' => $this->qualityExpirationDate,
            'createdAt' => $this->createdAt,
            'lastUpdatedAt' => $this->lastUpdatedAt,
        ];
    }
}