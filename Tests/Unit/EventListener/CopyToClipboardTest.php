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
use Brotkrueml\CodeHighlight\EventListener\CopyToClipboard;
use Brotkrueml\CodeHighlight\Tests\Traits\CreateEnrichCodeSnippetEventTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\Uri;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;

#[CoversClass(CopyToClipboard::class)]
final class CopyToClipboardTest extends TestCase
{
    use CreateEnrichCodeSnippetEventTrait;

    /**
     * @var LanguageServiceFactory&Stub
     */
    private Stub $languageServiceFactoryStub;

    protected function setUp(): void
    {
        $languageServiceStub = $this->createStub(LanguageService::class);
        $languageServiceStub
            ->method('sL')
            ->willReturnCallback(static fn($input): string => $input);

        $this->languageServiceFactoryStub = $this->createStub(LanguageServiceFactory::class);
        $this->languageServiceFactoryStub
            ->method('createFromSiteLanguage')
            ->willReturn($languageServiceStub);
    }

    #[Test]
    public function copyToClipboardIsDeactivated(): void
    {
        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([]),
            new Options([]),
            $this->createStub(ServerRequestInterface::class),
        );

        $subject = new CopyToClipboard($this->languageServiceFactoryStub);
        $subject($event);

        self::assertCount(0, $event->stylesCollector->getPaths());
        self::assertCount(0, $event->scriptsCollector->getPaths());
        self::assertSame('', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }

    #[Test]
    public function copyToClipboardIsActivated(): void
    {
        $requestStub = $this->createStub(ServerRequestInterface::class);
        $requestStub
            ->method('getAttribute')
            ->willReturn(new SiteLanguage(0, 'en', new Uri(), []));

        $event = $this->createEnrichCodeSnippetEvent(
            new SiteConfiguration([
                'codehighlightToolbarCopyToClipboard' => true,
            ]),
            new Options([]),
            $requestStub,
        );

        $subject = new CopyToClipboard($this->languageServiceFactoryStub);
        $subject($event);

        self::assertCount(1, $event->stylesCollector->getPaths());
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/plugins/toolbar/prism-toolbar.css', $event->stylesCollector->getPaths()[0]);
        self::assertCount(2, $event->scriptsCollector->getPaths());
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/plugins/toolbar/prism-toolbar.min.js', $event->scriptsCollector->getPaths()[0]);
        self::assertSame('EXT:codehighlight/Resources/Public/Prism/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js', $event->scriptsCollector->getPaths()[1]);
        self::assertSame('prismjs-copy="toolbar.copy" prismjs-copy-error="toolbar.copyError" prismjs-copy-success="toolbar.copySuccess"', $event->preAttributesCollector->__toString());
        self::assertSame('', $event->preClassesCollector->__toString());
        self::assertSame('', $event->codeAttributesCollector->__toString());
        self::assertSame('', $event->codeClassesCollector->__toString());
    }
}
