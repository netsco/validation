<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    // Register paths to refactor
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    // Skip certain files or patterns if needed
    $rectorConfig->skip([
        // Add patterns to skip if necessary
    ]);

    // PHP 8.0 migration set
    $rectorConfig->sets([
        SetList::PHP_84,
        LevelSetList::UP_TO_PHP_84,
    ]);

};
