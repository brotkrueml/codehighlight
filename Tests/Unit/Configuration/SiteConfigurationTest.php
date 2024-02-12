<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Tests\Unit\Configuration;

use Brotkrueml\CodeHighlight\Configuration\SiteConfiguration;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SiteConfigurationTest extends TestCase
{
    #[Test]
    public function fallbackValuesAreAssignedWhenConfigurationIsNotAvailable(): void
    {
        $subject = new SiteConfiguration([]);

        self::assertSame('', $subject->theme);
        self::assertSame('', $subject->commandLineDefaultHost);
        self::assertSame('', $subject->commandLineDefaultUser);
        self::assertFalse($subject->toolbarCopyToClipboard);
        self::assertFalse($subject->useUrlHash);
    }

    #[Test]
    public function stringValuesAreCorrectlyAssigned(): void
    {
        $subject = new SiteConfiguration([
            'codehighlightTheme' => 'some-theme',
            'codehighlightCommandLineDefaultHost' => 'some-host',
            'codehighlightCommandLineDefaultUser' => 'some-user',
        ]);

        self::assertSame('some-theme', $subject->theme);
        self::assertSame('some-host', $subject->commandLineDefaultHost);
        self::assertSame('some-user', $subject->commandLineDefaultUser);
    }

    #[Test]
    public function toolbarCopyToClipboardSetToTrue(): void
    {
        $subject = new SiteConfiguration([
            'codehighlightToolbarCopyToClipboard' => '1',
        ]);

        self::assertTrue($subject->toolbarCopyToClipboard);
    }

    #[Test]
    public function codehighlightUseUrlHash(): void
    {
        $subject = new SiteConfiguration([
            'codehighlightUseUrlHash' => '1',
        ]);

        self::assertTrue($subject->useUrlHash);
    }
}
