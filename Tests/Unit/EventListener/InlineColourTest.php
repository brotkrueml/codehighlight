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
use Brotkrueml\CodeHighlight\EventListener\InlineColour;
use Brotkrueml\CodeHighlight\Tests\Traits\CreateEnrichCodeSnippetEventTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

#[CoversClass(InlineColour::class)]
final class InlineColourTest extends TestCase
{
    use CreateEnrichCodeSnippetEventTrait;

    #[Test]
    public function inlineColourIsDeactivated(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([]),
            self::createStub(ServerRequestInterface::class),
        );

        $subject = new InlineColour();
        $subject($event);

        self::assertCount(0, $event->stylesCollector->getPaths());
        self::assertCount(0, $event->scriptsCollector->getPaths());
        self::assertSame('', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    public function inlineColourIsActivatedAndLanguageIsCss(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([
                'inlineColour' => '1',
                'programmingLanguage' => 'css',
            ]),
            self::createStub(ServerRequestInterface::class),
        );

        $subject = new InlineColour();
        $subject($event);

        self::assertCount(1, $event->stylesCollector->getPaths());
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/plugins/inline-color/prism-inline-color.css', $event->stylesCollector->getPaths()[0]);
        self::assertCount(3, $event->scriptsCollector->getPaths());
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/components/prism-css.min.js', $event->scriptsCollector->getPaths()[0]);
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/components/prism-css-extras.min.js', $event->scriptsCollector->getPaths()[1]);
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/plugins/inline-color/prism-inline-color.min.js', $event->scriptsCollector->getPaths()[2]);
        self::assertSame('', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    public function inlineColourIsActivatedAndLanguageIsHtml(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([
                'inlineColour' => '1',
                'programmingLanguage' => 'html',
            ]),
            self::createStub(ServerRequestInterface::class),
        );

        $subject = new InlineColour();
        $subject($event);

        self::assertCount(1, $event->stylesCollector->getPaths());
        self::assertCount(3, $event->scriptsCollector->getPaths());
        self::assertSame('', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    public function inlineColourIsActivatedAndLanguageIsPhp(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([
                'inlineColour' => '1',
                'programmingLanguage' => 'php',
            ]),
            self::createStub(ServerRequestInterface::class),
        );

        $subject = new InlineColour();
        $subject($event);

        self::assertCount(0, $event->stylesCollector->getPaths());
        self::assertCount(0, $event->scriptsCollector->getPaths());
        self::assertSame('', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    public function inlineColourIsDeactivatedAndLanguageIsCss(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([
                'inlineColour' => '0',
                'programmingLanguage' => 'css',
            ]),
            self::createStub(ServerRequestInterface::class),
        );

        $subject = new InlineColour();
        $subject($event);

        self::assertCount(0, $event->stylesCollector->getPaths());
        self::assertCount(0, $event->scriptsCollector->getPaths());
        self::assertSame('', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }
}
