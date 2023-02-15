<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\update;

use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\command\CommandIdExtractor;
use Rezident\WiseTelegramBot\command\CommandResolver;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\tests\command\stub\TheSecondCommand;
use Rezident\WiseTelegramBot\tests\command\stub\TheThirdOneCommand;
use Rezident\WiseTelegramBot\update\UpdateHandler;

class UpdateHandlerTest extends TestCase
{
    private CommandResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolver = $this->container->withSingleton(CommandResolver::class)->get(CommandResolver::class);
    }

    public function testHandleSpecifiedCommand(): void
    {
        $this->addInactiveCommand();
        $update = $this->addActiveCommand('/%s hello', 'hello');

        $this->container->get(UpdateHandler::class)->handle($update);
    }

    public function testHandleDefaultCommand(): void
    {
        $this->addInactiveCommand();
        $update = $this->addActiveCommand('/%s help', 'help', true);
        $update->getMessage()->text('/bad_cmd help');

        $this->container->get(UpdateHandler::class)->handle($update);
    }

    public function testHandleDefaultCommandWithTextOnly(): void
    {
        $this->addInactiveCommand();
        $update = $this->addActiveCommand('/%s prisma', 'prisma', true);
        $update->getMessage()->text('prisma');

        $this->container->get(UpdateHandler::class)->handle($update);
    }

    private function addInactiveCommand(): void
    {
        $result = $this->registerMock(TheSecondCommand::class);
        $result->expects($this->never())
            ->method('handle');

        $this->resolver->addCommands([$result::class]);
    }

    private function addActiveCommand(string $idTemplate, string $expectedArgument, bool $asDefault = false): Update
    {
        $result = $this->registerMock(TheThirdOneCommand::class);
        $id = $this->container->get(CommandIdExtractor::class)->extract(new \ReflectionClass($result));
        $update = $this->getUpdate(sprintf($idTemplate, $id));
        $result
            ->expects($this->once())
            ->method('handle')
            ->with($expectedArgument, $update);

        if ($asDefault) {
            $this->resolver->setDefaultCommand($result::class);
        } else {
            $this->resolver->addCommands([$result::class]);
        }

        return $update;
    }

    private function getUpdate(string $messageText): Update
    {
        $update = Update::fromArray(include __DIR__ . '/stub/update.php');
        $update->getMessage()->text($messageText);

        return $update;
    }
}
