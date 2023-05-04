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

    private ?int $exitCode = null;

    public function __construct(ProcCommand $command)
    {
        $this->process = proc_open($command->getParts(), Pipes::DESCRIPTORS, $pipesArray);
        $this->pipes = new Pipes($pipesArray);
    }

    public function isRunning(): bool
    {
        return proc_get_status($this->process)['running'];
    }

    public function getExitCode(): ?int
    {
        $exitCodeValue = proc_get_status($this->process)['exitcode'];
        if ($exitCodeValue >= 0) {
            $this->exitCode = $exitCodeValue;
        }

        return $this->exitCode;
    }
}
