<?php

namespace NsCreed\BankersAlgorithm;

class Resource
{
    private array $available;  // Available resources
    private array $allocated;  // Allocated resources
    private array $maxResource; // Maximum resources

    public function __construct(array $maxResource)
    {
        $this->available = $maxResource;
        $this->allocated = array_fill(0, count($maxResource), 0);
        $this->maxResource = $maxResource;
    }

    public function getAvailable(): array
    {
        return $this->available;
    }

    public function getAllocated(): array
    {
        return $this->allocated;
    }

    public function getMaxResource(): array
    {
        return $this->maxResource;
    }

    public function setAvailable($available): void
    {
        $this->available = $available;
    }

    public function setAllocated($allocated): void
    {
        $this->allocated = $allocated;
    }
}

