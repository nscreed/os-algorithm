<?php

namespace NsCreed\OsAlgorithm\Algorithms;

use NsCreed\OsAlgorithm\Process;

class RoundRobin implements ProcessContract
{
    use Processable;

    protected int $timeQuantum;

    public function __construct(int $timeQuantum)
    {
        $this->timeQuantum = $timeQuantum;
    }

    public function startProcess(): void
    {
        echo 'Round Robin Scheduling' . PHP_EOL;
        echo '==================================' . PHP_EOL;

        $tick = 0;
        $completed = 0;

        while ($completed < count($this->processes)) {
            $currentProcesses = $this->listCurrentProcess($tick);
            foreach ($currentProcesses as $currentProcess) {
                /** @var Process $currentProcess */
                echo '🕒' . $tick . ' => ';
                echo '✅' . $currentProcess->getName() . ' ';

                $remainingBurstTime = $currentProcess->getRemainingBurstTime();
                $executionTime = min($this->timeQuantum, $remainingBurstTime);

                $currentProcess->setTimeQuantum($executionTime);
                $currentProcess->execute();
                $tick += $executionTime;

                echo '🕒Remaining (' . $currentProcess->getRemainingBurstTime() . ') Waiting: ';

                foreach ($this->processes as $process) {
                    if ($process !== $currentProcess && $process->isProcessNotCompleted() && $process->isProcessArrived($tick)) {
                        echo $process->getName();
                        $process->setTimeQuantum($executionTime);
                        $process->wait();
                        echo '(' . $process->getWaitingTime() . ') ';
                    }
                }

                echo PHP_EOL;

                if ($currentProcess->getRemainingBurstTime() === 0) {
                    $completed++;
                }
            }
        }

        $this->printAverageTime();
    }

    private function listCurrentProcess(int $tick): array
    {
        $currentProcesses = [];
        foreach ($this->processes as $process) {
            if ($process->isProcessNotCompleted() && $process->isProcessArrived($tick)) {
                $currentProcesses[] = $process;
            }
        }

        return $currentProcesses;
    }
}
