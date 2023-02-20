<?php

declare(strict_types=1);

// https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/master/doc/config.rst
// https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/master/doc/ruleSets/index.rst

$finder = PhpCsFixer\Finder::create()->exclude('vendor');

$config = new PhpCsFixer\Config();

return $config
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setRules(
        [
            '@Symfony' => true,
            '@Symfony:risky' => true,
            '@PHP80Migration' => true,
            '@PHP80Migration:risky' => true,
            'concat_space' => ['spacing' => 'one'],
            'trailing_comma_in_multiline' => ['elements' => ['arguments', 'arrays', 'match', 'parameters']],
        ],
    )
    ->setHideProgress(false)
    ->setFinder($finder);
