<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withPhpVersion(Rector\ValueObject\PhpVersion::PHP_84)
    ->withSkip([
        \Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class,
        \Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class,
        \Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector::class,
        \Rector\CodeQuality\Rector\If_\CombineIfRector::class,
    ])
    ->withImportNames()
    ->withPhpSets()
    ->withRules([
        \Rector\Php84\Rector\Param\ExplicitNullableParamTypeRector::class
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        earlyReturn: true,
        strictBooleans: true,
    );
