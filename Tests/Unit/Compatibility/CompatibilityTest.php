<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Tests\Unit;

use Brotkrueml\CodeHighlight\Compatibility\Compatibility;
use PHPUnit\Framework\TestCase;

final class CompatibilityTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProviderForHasIconsConfigurationFile
     */
    public function hasIconsConfigurationFile(int $version, bool $expected): void
    {
        $subject = new Compatibility($version);

        self::assertSame($expected, $subject->hasIconsConfigurationFile());
    }

    public function dataProviderForHasIconsConfigurationFile(): iterable
    {
        yield 'Version 9 returns false' => [
            'version' => 9,
            'expected' => false,
        ];

        yield 'Version 10 returns false' => [
            'version' => 10,
            'expected' => false,
        ];

        yield 'Version 11 returns true' => [
            'version' => 11,
            'expected' => true,
        ];

        yield 'Version 12 returns true' => [
            'version' => 12,
            'expected' => true,
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderForHasFlexFormProcessor
     */
    public function hasFlexFormProcessor(int $version, bool $expected): void
    {
        $subject = new Compatibility($version);

        self::assertSame($expected, $subject->hasFlexFormProcessor());
    }

    public function dataProviderForHasFlexFormProcessor(): iterable
    {
        yield 'Version 9 returns false' => [
            'version' => 9,
            'expected' => false,
        ];

        yield 'Version 10 returns false' => [
            'version' => 10,
            'expected' => false,
        ];

        yield 'Version 11 returns true' => [
            'version' => 11,
            'expected' => true,
        ];

        yield 'Version 12 returns true' => [
            'version' => 12,
            'expected' => true,
        ];
    }
}
