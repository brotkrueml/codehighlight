<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Tests\Unit\EventListener;

use Brotkrueml\CodeHighlight\Configuration\Options;
use Brotkrueml\CodeHighlight\Configuration\SiteConfiguration;
use Brotkrueml\CodeHighlight\EventListener\CommandLine;
use Brotkrueml\CodeHighlight\Tests\Traits\CreateEnrichCodeSnippetEventTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

#[CoversClass(CommandLine::class)]
final class CommandLineTest extends TestCase
{
    use CreateEnrichCodeSnippetEventTrait;

    #[Test]
    public function commandLineIsDeactivated(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([]),
            $this->createStub(ServerRequestInterface::class),
        );

        $subject = new CommandLine();
        $subject($event);

        self::assertCount(0, $event->stylesCollector->getPaths());
        self::assertCount(0, $event->scriptsCollector->getPaths());
        self::assertSame('', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    #[DataProvider('provider')]
    public function commandLineIsActivated(array $options, array $siteConfiguration, string $expectedPreAttributes): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration($siteConfiguration),
            new Options($options),
            $this->createStub(ServerRequestInterface::class),
        );

        $subject = new CommandLine();
        $subject($event);

        self::assertCount(1, $event->stylesCollector->getPaths());
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/plugins/command-line/prism-command-line.css', $event->stylesCollector->getPaths()[0]);
        self::assertCount(1, $event->scriptsCollector->getPaths());
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/plugins/command-line/prism-command-line.min.js', $event->scriptsCollector->getPaths()[0]);
        self::assertSame($expectedPreAttributes, $event->preAttributesCollector->__toString());
        self::assertSame('command-line', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    public static function provider(): iterable
    {
        yield 'commandLineOutputLines is given' => [
            'options' => [
                'displayCommandLine' => '1',
                'commandLineOutputLines' => '1-2, 5, 9-20',
            ],
            'siteConfiguration' => [],
            'expectedPreAttributes' => 'data-output="1-2, 5, 9-20"',
        ];

        yield 'commandLineOutputFilter is given' => [
            'options' => [
                'displayCommandLine' => '1',
                'commandLineOutputFilter' => '(out)',
            ],
            'siteConfiguration' => [],
            'expectedPreAttributes' => 'data-filter-output="(out)"',
        ];

        yield 'commandLineServerPrompt is given' => [
            'options' => [
                'displayCommandLine' => '1',
                'commandLineServerPrompt' => 'PS C:\Users\Chris>',
            ],
            'siteConfiguration' => [],
            'expectedPreAttributes' => 'data-prompt="PS C:\Users\Chris&gt;"',
        ];

        yield 'commandLineServerUser is given' => [
            'options' => [
                'displayCommandLine' => '1',
                'commandLineServerUser' => 'chris',
            ],
            'siteConfiguration' => [],
            'expectedPreAttributes' => 'data-user="chris"',
        ];

        yield 'commandLineServerHost is given' => [
            'options' => [
                'displayCommandLine' => '1',
                'commandLineServerHost' => 'earth',
            ],
            'siteConfiguration' => [],
            'expectedPreAttributes' => 'data-host="earth"',
        ];

        yield 'commandLineDefaultUser is given' => [
            'options' => [
                'displayCommandLine' => '1',
            ],
            'siteConfiguration' => [
                'codehighlightCommandLineDefaultUser' => 'chris_default',
            ],
            'expectedPreAttributes' => 'data-user="chris_default"',
        ];

        yield 'commandLineDefaultHost is given' => [
            'options' => [
                'displayCommandLine' => '1',
            ],
            'siteConfiguration' => [
                'codehighlightCommandLineDefaultHost' => 'earth_default',
            ],
            'expectedPreAttributes' => 'data-host="earth_default"',
        ];

        yield 'commandLineServerUser and commandLineDefaultUser are given' => [
            'options' => [
                'displayCommandLine' => '1',
                'commandLineServerUser' => 'chris',
            ],
            'siteConfiguration' => [
                'codehighlightCommandLineDefaultUser' => 'chris_default',
            ],
            'expectedPreAttributes' => 'data-user="chris"',
        ];

        yield 'commandLineServerHost amd commandLineDefaultHost are given' => [
            'options' => [
                'displayCommandLine' => '1',
                'commandLineServerHost' => 'earth',
            ],
            'siteConfiguration' => [
                'codehighlightCommandLineDefaultHost' => 'earth_default',
            ],
            'expectedPreAttributes' => 'data-host="earth"',
        ];
    }
}
