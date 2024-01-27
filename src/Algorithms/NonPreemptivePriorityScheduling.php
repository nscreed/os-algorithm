<?php
namespace NsCreed\OsAlgorithm\Algorithms;

use NsCreed\OsAlgorithm\Process;

class NonPreemptivePriorityScheduling extends PreemptivePriorityScheduling
{
    public function startProcess(): void
    {
        echo 'Non-Preemptive Priority Scheduling' . PHP_EOL;
        echo '==================================' . PHP_EOL;

        $tick = 0;
        $completed = 0;
        $runningProcess = null;

        while ($completed < count($this->processes)) {
            echo '🕒'. $tick . ' => ';
            $currentProcesses = [];

            foreach ($this->processes as $process) {
                /** @var Process $process */
                if ($process->isProcessNotCompleted() && $process->isProcessArrived($tick)) {
                    echo $process->getName() . ' ';
                    $currentProcesses[] = $process;
                }
            }

            usort($currentProcesses, function ($a, $b) {
                if ($a->getPriority() === $b->getPriority()) {
                    return $a->getArrivalTime() - $b->getArrivalTime();
                }
                return $a->getPriority() - $b->getPriority();
            });

            if ($runningProcess && $runningProcess->isProcessNotCompleted()) {
                foreach ($currentProcesses as $pos => $currentProcess) {
                    if ($currentProcess->getName() === $runningProcess->getName()) {
                        unset($currentProcesses[$pos]);
                    }
                }
                array_unshift($currentProcesses, $runningProcess);
            }

            if (!empty($currentProcesses)) {
                echo " => ✅" . $currentProcesses[0]->getName() .' : ⌛';
                $runningProcess = $currentProcesses[0];
                $currentProcesses[0]->execute();
                if ($currentProcesses[0]->getRemainingBurstTime() === 0) {
                    $completed++;
                }
                foreach (array_slice($currentProcesses, 1) as $process) {
                    echo $process->getName();
                    $process->wait();
                    echo '(' . $process->getWaitingTime() .') ';
                }
            }

            $tick++;
            echo PHP_EOL;
        }

        $this->printAverageTime();
    }
}
