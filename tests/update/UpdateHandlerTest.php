<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\update;

use Rezident\SelfDocumentedTelegramBotSdk\types\Chat;
use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\SelfDocumentedTelegramBotSdk\types\Message;
use Rezident\WiseTelegramBot\command\CommandIdExtractor;
use Rezident\WiseTelegramBot\command\CommandResolver;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\tests\command\stub\TheSecondCommand;
use Rezident\WiseTelegramBot\tests\command\stub\TheThirdOneCommand;
use Rezident\WiseTelegramBot\update\UpdateHandler;

class UpdateHandlerTest extends TestCase
{
    private CommandIdExtractor $idExtractor;
    private CommandResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idExtractor = $this->container->get(CommandIdExtractor::class);
        $this->resolver = $this->container->withSingleton(CommandResolver::class)->get(CommandResolver::class);
    }

    public function testHandleSpecifiedCommand(): void
    {
        $this->registerMock(TheSecondCommand::class)
            ->expects($this->never())
            ->method('handle');
        $activeCommand = $this->createMock(TheThirdOneCommand::class);
        $id = $this->idExtractor->extract(new \ReflectionClass($activeCommand));
        $this->resolver->addCommands([$activeCommand::class]);
        $handler = $this->container->get(UpdateHandler::class);
        $update = $this->getUpdate(sprintf('/%s hello', $id));
        $activeCommand
            ->expects($this->once())
            ->method('handle')
            ->with('hello', $update);
        $this->container->set($activeCommand::class, $activeCommand);
        $handler->handle($update);
    }

    private function getUpdate(string $messageText): Update
    {
        $chat = Chat::new(1, 'private');
        $message = Message::new(1, 1, $chat)->text($messageText);

        return Update::new(1)->message($message);
    }
}
