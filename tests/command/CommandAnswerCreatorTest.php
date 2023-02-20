<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\command;

use Rezident\SelfDocumentedTelegramBotSdk\methods\SendMessageMethod;
use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\command\CommandAnswerCreator;
use Rezident\WiseTelegramBot\tests\base\Random;
use Rezident\WiseTelegramBot\tests\base\TestCase;

class CommandAnswerCreatorTest extends TestCase
{
    private const EXPECTED_PARSE_MODE = 'MarkdownV2';

    private Update $update;
    private CommandAnswerCreator $creator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->update = Update::fromArray(include __DIR__ . '/../update/stub/update.php');
        $this->creator = $this->container->get(CommandAnswerCreator::class);
    }

    public function testCreateNull(): void
    {
        $this->assertNull($this->creator->create($this->update, null));
    }

    public function testReturnSendMessageMethod(): void
    {
        $this->assertInstanceOf(SendMessageMethod::class, $this->creator->create($this->update, ''));
    }

    public function testCreateWithText(): void
    {
        $str = Random::str();
        $command = $this->creator->create($this->update, $str);
        $this->assertEquals($str, $command->toArray()['text']);
    }

    public function testCreateWithParseMode(): void
    {
        $this->assertEquals(
            self::EXPECTED_PARSE_MODE,
            $this->creator->create($this->update, '')->toArray()['parse_mode'],
        );
    }

    public function testCreateWithMultiline(): void
    {
        $str = Random::str();

        $arr = [$str, '', 5, true];
        $expected = sprintf('%s%s%s5%s1', $str, \PHP_EOL, \PHP_EOL, \PHP_EOL);
        $this->assertEquals($expected, $this->creator->create($this->update, $arr)->toArray()['text']);
    }

    public function testCreateWithChatId(): void
    {
        $this->assertEquals(
            $this->update->getMessage()->getChat()->getId(),
            $this->creator->create($this->update, '')->toArray()['chat_id'],
        );
    }
}
