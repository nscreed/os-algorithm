<?php

namespace NsCreed\OsAlgorithm\Algorithms;

use NsCreed\OsAlgorithm\Process;

interface ProcessContract
{
    public function addProcess(Process $process): void;
    public function startProcess(): void;
}
