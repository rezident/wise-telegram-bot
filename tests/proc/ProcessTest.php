<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\proc;

use Rezident\WiseTelegramBot\proc\ProcCommand;
use Rezident\WiseTelegramBot\proc\Process;
use Rezident\WiseTelegramBot\tests\base\TestCase;

class ProcessTest extends TestCase
{
    public function testRunProcess(): void
    {
        $process = new Process($this->getSleepCommand());
        $this->assertNotNull($this->getSleepCommandPid());
        $this->killSleepCommand();
        $this->assertNull($this->getSleepCommandPid());
        $this->assertFalse($process->isRunning());
    }

    public function testIsRunning(): void
    {
        $process = new Process($this->getSleepCommand());
        $this->assertTrue($process->isRunning());
        $this->killSleepCommand();
        $this->assertFalse($process->isRunning());
    }

    public function testSync(): void
    {
        $process = new Process(new ProcCommand('ls'));
        $process->sync();
        $this->assertSame(0, $process->getExitCode());
    }

    public function testSyncWithTimeout(): void
    {
        $process = new Process($this->getSleepCommand());
        $process->sync(1);
        $this->assertTrue($process->isRunning());
        $this->killSleepCommand();
    }

    public function testGetExitCode(): void
    {
        $process = new Process((new ProcCommand('bash'))->addOption('-c', 'exit 5'));
        $process->sync();
        $this->assertSame(5, $process->getExitCode());
    }

    public function testPullStdout(): void
    {
        $process = new Process((new ProcCommand('echo'))->addOption('hello'));
        $process->sync();
        $this->assertSame('hello', trim($process->getPipes()->pullStdout()));
    }

    public function testKillProcess(): void
    {
        $process = new Process($this->getSleepCommand());
        $process->kill();
        $this->assertFalse($process->isRunning());
        $this->assertNull($this->getSleepCommandPid());
    }

    public function testKillProcessOnDestruct()
    {
        $process = new Process($this->getSleepCommand());
        $this->assertNotNull($this->getSleepCommandPid());
        unset($process);
        $this->assertNull($this->getSleepCommandPid());
    }

    private function getSleepCommand(): ProcCommand
    {
        return (new ProcCommand('sleep'))->addOption('5');
    }

    private function getSleepCommandPid(): ?string
    {
        $execResult = shell_exec('pgrep -f sleep\ 5');

        return $execResult ? trim($execResult) : null;
    }

    private function killSleepCommand(): void
    {
        if ($pid = $this->getSleepCommandPid()) {
            shell_exec(sprintf('kill %s', $pid));
        }
    }
}
