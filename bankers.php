<?php

include __DIR__ . '/vendor/autoload.php';

use NsCreed\OsAlgorithm\BankersAlgorithm\Resource;
use NsCreed\OsAlgorithm\BankersAlgorithm\ResourceRequestAlgorithm;
use NsCreed\OsAlgorithm\BankersAlgorithm\SafetyAlgorithm;
use NsCreed\OsAlgorithm\BankersAlgorithm\Process;

// Define processes
$processes = [
    new Process('T0', [0, 0, 1, 2], [0, 0, 1, 2]),
    new Process('T1', [1, 0, 0, 0], [1, 7, 5, 0]),
    new Process('T2', [1, 3, 5, 4], [2, 3, 5, 6]),
    new Process('T3', [0, 6, 3, 2], [0, 6, 5, 2]),
    new Process('T4', [0, 0, 1, 4], [0, 6, 5, 6]),
];

// Define available resources
$availableResources = [1, 5, 2, 0];

// Create a Resource instance
$resource = new Resource($availableResources);

if (SafetyAlgorithm::isSafe($processes, $resource)) {
    echo "System is in a safe state." . PHP_EOL;
    SafetyAlgorithm::printSafeSequence();
} else {
    echo "System is not in a safe state. Deadlock may occur." . PHP_EOL;
}

// Define the resource request for T1
$requestT0 = [0, 4, 2, 0];

// Check if the resource request for T1 can be granted
if (ResourceRequestAlgorithm::canGrantImmediately($processes, 'T1', $requestT0, $resource)) {
    echo "Resource request for T1 can be granted without causing a deadlock." . PHP_EOL;
} else {
    echo "Resource request for T1 cannot be granted. It may lead to a deadlock." . PHP_EOL;
}
