<?php

declare(strict_types=1);

use Rezident\WiseTelegramBot\tests\base\Random;

return [
    'update_id' => Random::int(),
    'message' => [
        'message_id' => Random::int(),
        'date' => Random::int(),
        'chat' => [
            'id' => Random::int(),
            'type' => Random::str(),
        ],
    ],
];
