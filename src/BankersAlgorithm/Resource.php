<?php

namespace NsCreed\OsAlgorithm\BankersAlgorithm;

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

    public function setAvailable(array $available): void
    {
        $this->available = $available;
    }

    public function setAllocated(array $allocated): void
    {
        $this->allocated = $allocated;
    }

    /**
     * Add allocated resources to the current allocated resources.
     *
     * @param array $additionalResources
     */
    public function addAllocated(array $additionalResources): void
    {
        for ($i = 0; $i < count($this->allocated); $i++) {
            $this->allocated[$i] += $additionalResources[$i];
        }
    }

    /**
     * Subtract allocated resources from the current allocated resources.
     *
     * @param array $releasingResources
     */
    public function releaseAllocated(array $releasingResources): void
    {
        for ($i = 0; $i < count($this->allocated); $i++) {
            $this->allocated[$i] -= $releasingResources[$i];
        }
    }
}
