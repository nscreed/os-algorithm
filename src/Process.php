<?php

namespace NsCreed\OsAlgorithm;

class Process
{
    private string $name;
    private int $arrivalTime;
    private int $burstTime;
    private int $remainingBurstTime;
    private int $waitingTime = 0;
    private int $priority;
    private int $turnAroundTime = 0;
    private int $timeQuantum = 1;

    public function __construct(string $name, int $arrivalTime, int $burstTime, int $priority = 0)
    {
        $this->name = $name;
        $this->arrivalTime = $arrivalTime;
        $this->burstTime = $burstTime;
        $this->remainingBurstTime = $this->burstTime;
        $this->priority = $priority;
    }

    public function execute() : void
    {
        if ($this->remainingBurstTime === 0) {
            return;
        }

        $this->remainingBurstTime -= $this->timeQuantum;
        $this->turnAroundTime += $this->timeQuantum;
    }

    public function wait() : void
    {
        $this->waitingTime += $this->timeQuantum;
        $this->turnAroundTime += $this->timeQuantum;
    }

    public function isProcessArrived(int $currentTick) : bool
    {
        return $this->arrivalTime <= $currentTick;
    }

    public function isProcessNotCompleted() : bool
    {
        return $this->remainingBurstTime > 0;
    }

    public function isProcessCompleted() : bool
    {
        return !$this->isProcessNotCompleted();
    }

    public function __toString() : string
    {
        return sprintf('P=> %s : AT=> %s : BT=> %s : RT=> %s : WT=> %s', $this->name, $this->arrivalTime, $this->burstTime, $this->remainingBurstTime, $this->getWaitingTime());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getArrivalTime(): int
    {
        return $this->arrivalTime;
    }

    /**
     * @return int
     */
    public function getBurstTime(): int
    {
        return $this->burstTime;
    }

    /**
     * @return int
     */
    public function getRemainingBurstTime(): int
    {
        return $this->remainingBurstTime;
    }

    /**
     * @return int
     */
    public function getWaitingTime(): int
    {
        $wt = ($this->waitingTime);
        if ($wt < 0) return 0;

        return $wt;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getTurnAroundTime() : int
    {
        return $this->turnAroundTime;
    }

    public function setTimeQuantum(int $timeQuantum) : void
    {
        $this->timeQuantum = $timeQuantum;
    }
}
