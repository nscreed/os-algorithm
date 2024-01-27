<?php

namespace NsCreed\BankersAlgorithm;

class Process
{
    private int $pid;
    private array $allocation;
    private array $maxDemand;
    private array $need;
    private bool $completed;

    public function __construct(int $pid, array $allocation, array $maxDemand)
    {
        $this->pid = $pid;
        $this->allocation = $allocation;
        $this->maxDemand = $maxDemand;
        $this->need = $maxDemand;
        $this->completed = false;
    }

    public function getPid(): int
    {
        return $this->pid;
    }

    public function getAllocation(): array
    {
        return $this->allocation;
    }

    public function getMaxDemand(): array
    {
        return $this->maxDemand;
    }

    public function getNeed(): array
    {
        return $this->need;
    }

    public function setAllocation($allocation): void
    {
        $this->allocation = $allocation;
        $this->need = array_map(function ($max, $alloc) {
            return $max - $alloc;
        }, $this->maxDemand, $this->allocation);
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function setCompleted($completed): void
    {
        $this->completed = $completed;
    }
}
