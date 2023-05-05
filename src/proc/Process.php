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

    private int $exitCode = -1;

    private bool $isRunning;

    public function __construct(ProcCommand $command)
    {
        $this->process = proc_open($command->getParts(), Pipes::DESCRIPTORS, $pipesArray);
        $this->pipes = new Pipes($pipesArray);
    }

    public function isRunning(): bool
    {
        $this->updateProcessStatus();

        return $this->isRunning;
    }

    public function getExitCode(): ?int
    {
        $this->updateProcessStatus();

        return $this->exitCode;
    }

    public function sync(?int $msTimeout = null): void
    {
        $nsWaitUntil = null !== $msTimeout ? microtime(true) + $msTimeout / 1000 : null;
        while ($this->isRunning()) {
            if (null !== $nsWaitUntil && microtime(true) > $nsWaitUntil) {
                break;
            }
        }
    }

    public function getPipes(): Pipes
    {
        return $this->pipes;
    }

    public function kill(): void
    {
        if (!\is_resource($this->process)) {
            return;
        }

        proc_terminate($this->process);
        $closeExitCode = proc_close($this->process);
        if ($closeExitCode >= 0) {
            $this->exitCode = $closeExitCode;
        }
        $this->isRunning = false;
    }

    public function isOk(): bool
    {
        return 0 === $this->getExitCode();
    }

    public function isFail(): bool
    {
        return !$this->isOk();
    }

    private function updateProcessStatus(): void
    {
        if (!\is_resource($this->process)) {
            return;
        }

        $status = proc_get_status($this->process);
        $this->isRunning = $status['running'];
        if ($status['exitcode'] >= 0) {
            $this->exitCode = $status['exitcode'];
        }
    }

    public function __destruct()
    {
        $this->kill();
    }
}
