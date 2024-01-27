<?php

include __DIR__ . '/vendor/autoload.php';

use NsCreed\OsAlgorithm\BankersAlgorithm\Resource;
use NsCreed\OsAlgorithm\BankersAlgorithm\ResourceRequestAlgorithm;
use NsCreed\OsAlgorithm\BankersAlgorithm\SafetyAlgorithm;
use NsCreed\OsAlgorithm\BankersAlgorithm\Process;

// Define processes
$processes = [
    new Process('T0', [0, 1, 0], [7, 5, 3]),
    new Process('T1', [2, 0, 0], [3, 2, 2]),
    new Process('T2', [3, 0, 2], [9, 0, 2]),
    new Process('T3', [2, 1, 1], [2, 2, 2]),
    new Process('T4', [0, 0, 2], [4, 3, 3]),
];

// Define available resources
$availableResources = [3, 3, 2];

// Create a Resource instance
$resource = new Resource($availableResources);

// Check if the system is in a safe state
if (SafetyAlgorithm::isSafe($processes, $resource)) {
    echo "System is in a safe state." . PHP_EOL;
    SafetyAlgorithm::printSafeSequence();
} else {
    echo "System is not in a safe state. Deadlock may occur." . PHP_EOL;
}

// Define the resource request for T1
$requestT1 = [1, 0, 2];

// Check if the resource request for T1 can be granted
if (ResourceRequestAlgorithm::canGrantImmediately($processes, 'T1', $requestT1, $resource)) {
    echo "Resource request for T1 can be granted without causing a deadlock." . PHP_EOL;
    SafetyAlgorithm::printSafeSequence();
} else {
    echo "Resource request for T1 cannot be granted. It may lead to a deadlock." . PHP_EOL;
}

// Define the resource request for T0
$requestT0 = [0, 2, 0];

// Check if the resource request for T0 can be granted
if (ResourceRequestAlgorithm::canGrantImmediately($processes, 'T0', $requestT0, new Resource([2,3,0]))) {
    echo "Resource request for T0 can be granted without causing a deadlock." . PHP_EOL;
    SafetyAlgorithm::printSafeSequence();
} else {
    echo "Resource request for T0 cannot be granted. It may lead to a deadlock." . PHP_EOL;
}
