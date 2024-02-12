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
use Brotkrueml\CodeHighlight\EventListener\LineNumbers;
use Brotkrueml\CodeHighlight\Tests\Traits\CreateEnrichCodeSnippetEventTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

#[CoversClass(LineNumbers::class)]
final class LineNumbersTest extends TestCase
{
    use CreateEnrichCodeSnippetEventTrait;

    #[Test]
    public function optionShowLineNumbersIsDeactivated(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([]),
            $this->createStub(ServerRequestInterface::class),
        );

        $subject = new LineNumbers();
        $subject($event);

        self::assertCount(0, $event->stylesCollector->getPaths());
        self::assertCount(0, $event->scriptsCollector->getPaths());
        self::assertSame('', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    public function optionShowLineNumberIsActivated(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([
                'showLineNumbers' => '1',
            ]),
            $this->createStub(ServerRequestInterface::class),
        );

        $subject = new LineNumbers();
        $subject($event);

        self::assertCount(1, $event->stylesCollector->getPaths());
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/plugins/line-numbers/prism-line-numbers.css', $event->stylesCollector->getPaths()[0]);
        self::assertCount(1, $event->scriptsCollector->getPaths());
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/plugins/line-numbers/prism-line-numbers.min.js', $event->scriptsCollector->getPaths()[0]);
        self::assertSame('', $event->preAttributesCollector->__toString());
        self::assertSame('line-numbers', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    public function optionShowLineNumberIsActivatedAndStartWithLineNumberGreater1(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([
                'showLineNumbers' => '1',
                'startWithLineNumber' => '2',
            ]),
            $this->createStub(ServerRequestInterface::class),
        );

        $subject = new LineNumbers();
        $subject($event);

        self::assertCount(1, $event->stylesCollector->getPaths());
        self::assertCount(1, $event->scriptsCollector->getPaths());
        self::assertSame('start="2"', $event->preAttributesCollector->__toString());
        self::assertSame('line-numbers', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    public function optionShowLineNumberIsActivatedAndStartWithLineNumberIs1(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([
                'showLineNumbers' => '1',
                'startWithLineNumber' => '1',
            ]),
            $this->createStub(ServerRequestInterface::class),
        );

        $subject = new LineNumbers();
        $subject($event);

        self::assertCount(1, $event->stylesCollector->getPaths());
        self::assertCount(1, $event->scriptsCollector->getPaths());
        self::assertSame('', $event->preAttributesCollector->__toString());
        self::assertSame('line-numbers', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    public function optionShowLineNumberIsActivatedAndStartWithLineNumberIsGreater1(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([
                'showLineNumbers' => '0',
                'startWithLineNumber' => '2',
            ]),
            $this->createStub(ServerRequestInterface::class),
        );

        $subject = new LineNumbers();
        $subject($event);

        self::assertCount(0, $event->stylesCollector->getPaths());
        self::assertCount(0, $event->scriptsCollector->getPaths());
        self::assertSame('', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }
}
