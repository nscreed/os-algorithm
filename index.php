<?php

use NsCreed\OsAlgorithm\Algorithms\NonPreemptivePriorityScheduling;
use NsCreed\OsAlgorithm\Algorithms\PreemptivePriorityScheduling;
use NsCreed\OsAlgorithm\Algorithms\RoundRobin;
use NsCreed\OsAlgorithm\Process;

include __DIR__ . '/vendor/autoload.php';

$priorityScheduling = new RoundRobin(2);

$priorityScheduling->addProcess( new Process('A', 2, 7));
$priorityScheduling->addProcess( new Process('B', 4, 3));
$priorityScheduling->addProcess( new Process('C', 6, 2));
$priorityScheduling->addProcess( new Process('D', 8, 6));
$priorityScheduling->addProcess( new Process('E', 0, 5));

$priorityScheduling->startProcess();
