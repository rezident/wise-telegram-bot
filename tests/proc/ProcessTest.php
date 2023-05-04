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
        new Process($this->getSleepCommand());
        $this->assertNotNull($this->getSleepCommandPid());
        $this->killSleepCommand();
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
