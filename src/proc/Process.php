<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\proc;

class Process
{
    /**
     * @var resource
     */
    private $process;

    private Pipes $pipes;

    public function __construct(ProcCommand $command)
    {
        $this->process = proc_open($command->getParts(), Pipes::DESCRIPTORS, $pipesArray);
        $this->pipes = new Pipes($pipesArray);
    }

    public function isRunning(): bool
    {
        $status = proc_get_status($this->process);

        return $status['running'];
    }
}
