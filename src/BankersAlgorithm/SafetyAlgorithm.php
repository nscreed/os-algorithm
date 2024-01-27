<?php

namespace NsCreed\BankersAlgorithm;

class SafetyAlgorithm
{
    /**
     * Check if the system is in a safe state.
     *
     * @param array $processes
     * @param Resource $resource
     * @return bool
     */
    public static function isSafe(array $processes, Resource $resource): bool
    {
        // Initialize work and finish arrays
        $work = $resource->getAvailable();
        $finish = array_fill(0, count($processes), false);

        // Clone processes to avoid modifying the original objects
        $clonedProcesses = [];
        foreach ($processes as $process) {
            $clonedProcesses[] = clone $process;
        }

        $safeSequence = [];

        // Iterate until all processes are finished or deadlock detected
        $iteration = 0;
        while (count($safeSequence) < count($processes) && $iteration < count($processes)) {
            $found = false;

            foreach ($clonedProcesses as $index => $process) {
                if (!$finish[$index] && self::canBeAllocated($process, $work)) {
                    // Process can be allocated resources
                    $work = self::addResources($work, $process->getAllocation());
                    $finish[$index] = true;
                    $safeSequence[] = $process->getPid();
                    $found = true;
                }
            }

            // If no process can be allocated, break loop to avoid deadlock
            if (!$found) {
                break;
            }

            $iteration++;
        }

        return count($safeSequence) === count($processes);
    }

    /**
     * Check if a process can be allocated resources.
     *
     * @param Process $process
     * @param array $work
     * @return bool
     */
    private static function canBeAllocated(Process $process, array $work): bool
    {
        $need = $process->getNeed();
        for ($i = 0; $i < count($need); $i++) {
            if ($need[$i] > $work[$i]) {
                return false;
            }
        }
        return true;
    }

    /**
     * Add allocated resources to the work array.
     *
     * @param array $work
     * @param array $allocation
     * @return array
     */
    private static function addResources(array $work, array $allocation): array
    {
        for ($i = 0; $i < count($work); $i++) {
            $work[$i] += $allocation[$i];
        }
        return $work;
    }
}
