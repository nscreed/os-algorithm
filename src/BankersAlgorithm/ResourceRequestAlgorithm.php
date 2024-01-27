<?php

namespace NsCreed\OsAlgorithm\BankersAlgorithm;

class ResourceRequestAlgorithm
{
    /**
     * Check if the resource request can be granted.
     *
     * @param array $processes
     * @param string $processName
     * @param array $request
     * @param Resource $resource
     * @return bool
     */
    public static function canGrantImmediately(array $processes, string $processName, array $request, Resource $resource) : bool
    {
        $process = null;
        $processPosition = 0;
        foreach ($processes as $pid => $proc) {
            /** @var Process $proc */
            if ($proc->getPid() === $processName) {
                $process = $proc;
                $processPosition = $pid;
            }
        }

        $need = $process->getNeed();
        $available = $resource->getAvailable();

        SafetyAlgorithm::printResource($need);
        SafetyAlgorithm::printResource($available);

        for ($i = 0; $i < count($need); $i++) {
            if ($request[$i] > $need[$i] || $request[$i] > $available[$i]) {
                return false;
            }
        }

        SafetyAlgorithm::printResource($need);
        SafetyAlgorithm::printResource($available);

        $allocation = $process->getAllocation();
        for ($i = 0; $i < count($need); $i++) {
            $available[$i] = $available[$i] - $request[$i];
            $allocation[$i] = $available[$i] + $request[$i];
            $need[$i] = $need[$i] - $request[$i];
        }

        $process->setAllocation($allocation);
        $process->setNeed($need);

        $processes[$processPosition] = $process;

        return SafetyAlgorithm::isSafe($processes, $resource);
    }

    /**
     * Add allocated resources to the given resources array.
     *
     * @param array $resources
     * @param array $allocation
     * @return array
     */
    private static function addResources(array $resources, array $allocation): array
    {
        for ($i = 0; $i < count($resources); $i++) {
            $resources[$i] += $allocation[$i];
        }
        return $resources;
    }

    /**
     * Subtract allocated resources from the given resources array.
     *
     * @param array $resources
     * @param array $allocation
     * @return array
     */
    private static function subtractResources(array $resources, array $allocation): array
    {
        for ($i = 0; $i < count($resources); $i++) {
            $resources[$i] -= $allocation[$i];
        }
        return $resources;
    }
}
