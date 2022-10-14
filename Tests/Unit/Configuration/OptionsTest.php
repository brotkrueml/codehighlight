<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Tests\Unit\Configuration;

use Brotkrueml\CodeHighlight\Configuration\Options;
use PHPUnit\Framework\TestCase;

final class OptionsTest extends TestCase
{
    /**
     * @test
     */
    public function fallbackValuesAreAssignedWhenOptionIsNotAvailable(): void
    {
        $subject = new Options([]);

        self::assertSame('', $subject->programmingLanguage);
        self::assertSame('', $subject->filename);
        self::assertFalse($subject->showLineNumbers);
        self::assertSame(0, $subject->startWithLineNumber);
        self::assertSame('', $subject->highlightLines);
        self::assertFalse($subject->displayCommandLine);
        self::assertSame('', $subject->commandLineServerUser);
        self::assertSame('', $subject->commandLineServerHost);
        self::assertSame('', $subject->commandLineServerPrompt);
        self::assertSame('', $subject->commandLineOutputLines);
        self::assertSame('', $subject->commandLineOutputFilter);
        self::assertFalse($subject->inlineColour);
    }

    /**
     * @test
     */
    public function stringAndIntValuesAreCorrectlyAssigned(): void
    {
        $subject = new Options([
            'programmingLanguage' => 'php',
            'filename' => 'some-file.php',
            'startWithLineNumber' => '42',
            'highlightLines' => '1-3',
            'commandLineServerUser' => 'some-user',
            'commandLineServerHost' => 'some-host',
            'commandLineServerPrompt' => 'some-prompt',
            'commandLineOutputLines' => '1-2, 5, 9-20',
            'commandLineOutputFilter' => '(filter)',
        ]);

        self::assertSame('php', $subject->programmingLanguage);
        self::assertSame('some-file.php', $subject->filename);
        self::assertSame(42, $subject->startWithLineNumber);
        self::assertSame('1-3', $subject->highlightLines);
        self::assertSame('some-user', $subject->commandLineServerUser);
        self::assertSame('some-host', $subject->commandLineServerHost);
        self::assertSame('some-prompt', $subject->commandLineServerPrompt);
        self::assertSame('1-2, 5, 9-20', $subject->commandLineOutputLines);
        self::assertSame('(filter)', $subject->commandLineOutputFilter);
    }

    /**
     * @test
     */
    public function showLineNumbersSetToTrue(): void
    {
        $subject = new Options([
            'showLineNumbers' => '1',
        ]);

        self::assertTrue($subject->showLineNumbers);
    }

    /**
     * @test
     */
    public function showDisplayCommandLineSetToTrue(): void
    {
        $subject = new Options([
            'displayCommandLine' => '1',
        ]);

        self::assertTrue($subject->displayCommandLine);
    }

    /**
     * @test
     */
    public function inlineColourSetToTrue(): void
    {
        $subject = new Options([
            'inlineColour' => '1',
        ]);

        self::assertTrue($subject->inlineColour);
    }
}
