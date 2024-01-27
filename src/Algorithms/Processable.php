<?php

namespace NsCreed\OsAlgorithm\Algorithms;

use NsCreed\OsAlgorithm\Process;

trait Processable
{
    protected array $processes;

    public function addProcess(Process $process): void
    {
        $this->processes[] = $process;
    }

    public function printAverageTime() : void
    {
        // Average waiting time
        $totalWaitingTime = array_reduce($this->processes, function ($carry, $process) {
            return $carry + $process->getWaitingTime();
        }, 0);

        $averageWaitingTime = $totalWaitingTime / count($this->processes);
        echo PHP_EOL . 'Average Waiting Time: ' . $averageWaitingTime;

        // Average Turnaround time
        $totalTurnAroundTime = array_reduce($this->processes, function ($carry, $process) {
            /** @var Process $process */
            return $carry + $process->getTurnAroundTime();
        }, 0);

        $totalTurnAroundTime = $totalTurnAroundTime / count($this->processes);
        echo PHP_EOL . 'Average Turnaround Time: ' . $totalTurnAroundTime;
    }
}
