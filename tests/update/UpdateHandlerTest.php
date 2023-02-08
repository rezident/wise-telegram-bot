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
        $this->addInactiveCommand();
        $update = $this->addActiveCommand('/%s hello', 'hello');

        $handler = $this->container->get(UpdateHandler::class);
        $handler->handle($update);
    }

    private function addInactiveCommand(): void
    {
        $result = $this->registerMock(TheSecondCommand::class);
        $result->expects($this->never())
            ->method('handle');

        $this->resolver->addCommands([$result::class]);
    }

    private function addActiveCommand(string $idTemplate, string $expectedArgument): Update
    {
        $result = $this->registerMock(TheThirdOneCommand::class);
        $id = $this->idExtractor->extract(new \ReflectionClass($result));
        $update = $this->getUpdate(sprintf($idTemplate, $id));
        $result
            ->expects($this->once())
            ->method('handle')
            ->with($expectedArgument, $update);

        $this->resolver->addCommands([$result::class]);

        return $update;
    }

    private function getUpdate(string $messageText): Update
    {
        $chat = Chat::new(1, 'private');
        $message = Message::new(1, 1, $chat)->text($messageText);

        return Update::new(1)->message($message);
    }
}
