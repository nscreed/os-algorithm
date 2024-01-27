<?php

namespace NsCreed\OsAlgorithm\BankersAlgorithm;

class Process
{
    private string $pid;
    private array $allocation;
    private array $maxDemand;
    private array $need;
    private bool $completed;

    public function __construct(string $pid, array $allocation, array $maxDemand)
    {
        $this->pid = $pid;
        $this->allocation = $allocation;
        $this->maxDemand = $maxDemand;
        $this->makeNeed();
        $this->completed = false;
    }

    private function makeNeed() : void
    {
        foreach ($this->maxDemand as $index => $maxDemand) {
            $this->need[$index] = $maxDemand - $this->allocation[$index];
        }
    }

    public function getPid(): string
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
