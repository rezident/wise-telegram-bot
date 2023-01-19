# Wise Telegram Bot

## Creating the bot

To create a new bot object, you need a token. 
This token can be obtained with a special bot - [@BotFather](https://t.me/BotFather).
Creating a bot object:

```php
$bot = new \Rezident\WiseTelegramBot\Bot('special token');
```

## Processing updates

The bot can receive the update in two ways: 
by requesting it itself (using the [getUpdates](https://core.telegram.org/bots/api#getupdates) method) 
or by receiving it as an associative array (using [webhooks](https://core.telegram.org/bots/api#getupdates)).

### Associative array

For the bot to process the update as an associative array,
it must be passed to the `handleUpdate` method:

```php
$update = json_decode($body);

$bot = new \Rezident\WiseTelegramBot\Bot('special token');
$bot->handleUpdate($update);
```
