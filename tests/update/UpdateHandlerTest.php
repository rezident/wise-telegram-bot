<?php

declare(strict_types=1);

namespace Rezident\WiseTelegramBot\tests\update;

use Rezident\SelfDocumentedTelegramBotSdk\components\Executor;
use Rezident\SelfDocumentedTelegramBotSdk\methods\SendMessageMethod;
use Rezident\SelfDocumentedTelegramBotSdk\types\GettingUpdates\Update;
use Rezident\WiseTelegramBot\command\CommandAnswerCreator;
use Rezident\WiseTelegramBot\command\CommandIdExtractor;
use Rezident\WiseTelegramBot\command\CommandResolver;
use Rezident\WiseTelegramBot\tests\base\TestCase;
use Rezident\WiseTelegramBot\tests\command\stub\TheSecondCommand;
use Rezident\WiseTelegramBot\tests\command\stub\TheThirdOneCommand;
use Rezident\WiseTelegramBot\update\UpdateFilter;
use Rezident\WiseTelegramBot\update\UpdateHandler;

class UpdateHandlerTest extends TestCase
{
    private const ACTIVE_COMMAND_RETURN = 'returned text';

    private CommandResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolver = $this->container->withSingleton(CommandResolver::class)->get(CommandResolver::class);
        $this->registerMock(Executor::class);
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

    public function testCallCommandAnswerCommand(): void
    {
        $update = $this->addActiveCommand('/%s', '', false, self::ACTIVE_COMMAND_RETURN);
        $this->addInactiveCommand();
        $sendMessageMethodMock = $this->createMock(SendMessageMethod::class);
        $sendMessageMethodMock
            ->expects($this->once())
            ->method('exec');

        $this->registerMock(CommandAnswerCreator::class)
            ->expects($this->once())
            ->method('create')
            ->with($update, self::ACTIVE_COMMAND_RETURN)
            ->willReturn($sendMessageMethodMock);

        $this->container->get(UpdateHandler::class)->handle($update);
    }

    public function testCallUpdateFilter(): void
    {
        $update = $this->addActiveCommand('/%s hello', 'hello');
        $this->registerMock(UpdateFilter::class)
            ->expects($this->once())
            ->method('filter')
            ->willReturn($update)
            ->with($update);

        $this->container->get(UpdateHandler::class)->handle($update);
    }

    private function addInactiveCommand(): void
    {
        $result = $this->registerMock(TheSecondCommand::class);
        $result->expects($this->never())
            ->method('handle');

        $this->resolver->addCommands([$result::class]);
    }

    private function addActiveCommand(
        string $idTemplate,
        string $expectedArgument,
        bool $asDefault = false,
        ?string $willReturn = null,
    ): Update {
        $result = $this->registerMock(TheThirdOneCommand::class);
        $id = $this->container->get(CommandIdExtractor::class)->extract(new \ReflectionClass($result));
        $update = $this->getUpdate(sprintf($idTemplate, $id));
        $result
            ->expects($this->once())
            ->method('handle')
            ->willReturn($willReturn)
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
