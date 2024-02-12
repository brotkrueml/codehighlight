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
use Brotkrueml\CodeHighlight\EventListener\HighlightLines;
use Brotkrueml\CodeHighlight\Tests\Traits\CreateEnrichCodeSnippetEventTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

#[CoversClass(HighlightLines::class)]
final class HighlightLinesTest extends TestCase
{
    use CreateEnrichCodeSnippetEventTrait;

    #[Test]
    public function highlightLinesIsSetAndUseUrlHashIsDeactivated(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([]),
            $this->createStub(ServerRequestInterface::class),
        );

        $subject = new HighlightLines();
        $subject($event);

        self::assertCount(0, $event->stylesCollector->getPaths());
        self::assertCount(0, $event->scriptsCollector->getPaths());
        self::assertSame('', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    public function highlightLinesIsSet(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([
                'highlightLines' => '3-5',
            ]),
            $this->createStub(ServerRequestInterface::class),
        );

        $subject = new HighlightLines();
        $subject($event);

        self::assertCount(1, $event->stylesCollector->getPaths());
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/plugins/line-highlight/prism-line-highlight.css', $event->stylesCollector->getPaths()[0]);
        self::assertCount(1, $event->scriptsCollector->getPaths());
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/plugins/line-highlight/prism-line-highlight.min.js', $event->scriptsCollector->getPaths()[0]);
        self::assertSame('line="3-5"', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    public function highlightLinesIsSetAndStartWithLineNumberIsGreater1(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([
                'highlightLines' => '3-5',
                'startWithLineNumber' => '2',
            ]),
            $this->createStub(ServerRequestInterface::class),
        );

        $subject = new HighlightLines();
        $subject($event);

        self::assertCount(1, $event->stylesCollector->getPaths());
        self::assertCount(1, $event->scriptsCollector->getPaths());
        self::assertSame('line="3-5" line-offset="1"', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    public function highlightLinesIsSetAndStartWithLineNumberIs1(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([
                'highlightLines' => '3-5',
                'startWithLineNumber' => '1',
            ]),
            $this->createStub(ServerRequestInterface::class),
        );

        $subject = new HighlightLines();
        $subject($event);

        self::assertCount(1, $event->stylesCollector->getPaths());
        self::assertCount(1, $event->scriptsCollector->getPaths());
        self::assertSame('line="3-5"', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    public function highlightLinesIsNotSetAndStartWithLineNumberIsGreater0(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([
                'highlightLines' => '',
                'startWithLineNumber' => '2',
            ]),
            $this->createStub(ServerRequestInterface::class),
        );

        $subject = new HighlightLines();
        $subject($event);

        self::assertCount(0, $event->stylesCollector->getPaths());
        self::assertCount(0, $event->scriptsCollector->getPaths());
        self::assertSame('', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    public function useUrlHashIsActivated(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([
                'codehighlightUseUrlHash' => true,
            ]),
            new Options([]),
            $this->createStub(ServerRequestInterface::class),
        );

        $subject = new HighlightLines();
        $subject($event);

        self::assertCount(1, $event->stylesCollector->getPaths());
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/plugins/line-highlight/prism-line-highlight.css', $event->stylesCollector->getPaths()[0]);
        self::assertCount(1, $event->scriptsCollector->getPaths());
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/plugins/line-highlight/prism-line-highlight.min.js', $event->scriptsCollector->getPaths()[0]);
        self::assertSame('', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    public function useUrlHashIsActivatedAndStartWithLineNumberIsGreater1(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([
                'codehighlightUseUrlHash' => true,
            ]),
            new Options([
                'startWithLineNumber' => 2,
            ]),
            $this->createStub(ServerRequestInterface::class),
        );

        $subject = new HighlightLines();
        $subject($event);

        self::assertCount(1, $event->stylesCollector->getPaths());
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/plugins/line-highlight/prism-line-highlight.css', $event->stylesCollector->getPaths()[0]);
        self::assertCount(1, $event->scriptsCollector->getPaths());
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/plugins/line-highlight/prism-line-highlight.min.js', $event->scriptsCollector->getPaths()[0]);
        self::assertSame('', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }
}
