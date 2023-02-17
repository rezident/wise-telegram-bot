<?php

declare(strict_types=1);

use Rezident\WiseTelegramBot\Bot;

require_once __DIR__ . '/vendor/autoload.php';

function createBot(): Bot
{
    $bot = new Bot('5983262266:AAHvG06JTXaQ4o-zvTWSeez2kh-Wzxx0g9w');
    $bot->readCommands(__DIR__ . '/bot/commands');

    return $bot;
}
