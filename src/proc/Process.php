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
        return $this->getProcessStatus()['running'];
    }

    public function getExitCode(): ?int
    {
        return $this->getProcessStatus()['exitcode'] >= 0 ? $this->getProcessStatus()['exitcode'] : null;
    }

    public function sync(): void
    {
        while ($this->isRunning()) {
            // do nothing
        }
    }

    public function getPipes(): Pipes
    {
        return $this->pipes;
    }

    private function getProcessStatus()
    {
        static $exitCode = -1;
        $status = proc_get_status($this->process);
        if ($status['exitcode'] >= 0) {
            $exitCode = $status['exitcode'];
        }

        $status['exitcode'] = $exitCode;

        return $status;
    }
}
