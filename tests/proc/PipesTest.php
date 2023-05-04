<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\proc;

use Rezident\WiseTelegramBot\proc\exceptions\ArrayItemsIsNotResourcesException;
use Rezident\WiseTelegramBot\proc\exceptions\WrongArraySizeException;
use Rezident\WiseTelegramBot\proc\Pipes;
use Rezident\WiseTelegramBot\tests\base\TestCase;

class PipesTest extends TestCase
{
    public function testDescriptorConst(): void
    {
        $this->assertEquals([0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], Pipes::DESCRIPTORS);
    }

    public function testThrowWrongArraySizeException(): void
    {
        $this->expectException(WrongArraySizeException::class);
        new Pipes(array_fill(0, \count(Pipes::DESCRIPTORS) + 1, 0));
    }

    public function testThrowArrayItemsIsNotResourcesException(): void
    {
        $this->expectException(ArrayItemsIsNotResourcesException::class);
        new Pipes(array_fill(0, \count(Pipes::DESCRIPTORS), 0));
    }

    public function testCreatePipesWithUnBlockStreams(): void
    {
        $stream = fopen(__FILE__, 'r');
        $this->assertTrue(stream_get_meta_data($stream)['blocked']);
        new Pipes([$stream, $stream, $stream]);
        $this->assertFalse(stream_get_meta_data($stream)['blocked']);
    }

    public function testPullStdout(): void
    {
        $currentFile = fopen(__FILE__, 'r');
        $pipes = new Pipes([$currentFile, $currentFile, fopen('data://text/plain;base64,', 'r')]);
        $this->assertEquals('', $pipes->pullStderr());
        $this->assertEquals(file_get_contents(__FILE__), $pipes->pullStdout());
        $this->assertEquals('', $pipes->pullStdout());
    }

    public function testPullStderr(): void
    {
        $currentFile = fopen(__FILE__, 'r');
        $pipes = new Pipes([$currentFile, fopen('data://text/plain;base64,', 'r'), $currentFile]);
        $this->assertEquals('', $pipes->pullStdout());
        $this->assertEquals(file_get_contents(__FILE__), $pipes->pullStderr());
        $this->assertEquals('', $pipes->pullStderr());
    }

    public function testClosePipes(): void
    {
        $currentFile = fopen(__FILE__, 'r');
        $pipes = new Pipes([$currentFile, $currentFile, $currentFile]);
        $this->assertIsNotClosedResource($currentFile);
        $pipes->close();
        $this->assertIsClosedResource($currentFile);
    }
}
