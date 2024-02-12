<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\PHPUnit\Set\PHPUnitSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/Classes',
        __DIR__ . '/Configuration',
        __DIR__ . '/Tests',
    ])
    ->withPhpSets()
    ->withAutoloadPaths([
        __DIR__ . '/.Build/vendor/autoload.php',
    ])
    ->withImportNames(
        importShortClasses: false,
        removeUnusedImports: true,
    )
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
        earlyReturn: true,
    )
    ->withSets([
        PHPUnitSetList::PHPUNIT_100,
    ])
    ->withRootFiles()
    ->withSkip([
        AddLiteralSeparatorToNumberRector::class,
    ]);
