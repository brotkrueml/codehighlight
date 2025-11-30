<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\UserFunctions;

use Brotkrueml\CodeHighlight\Collector\AssetCollector;
use Brotkrueml\CodeHighlight\Collector\TagAttributesCollector;
use Brotkrueml\CodeHighlight\Collector\TagAttributeValuesCollector;
use Brotkrueml\CodeHighlight\Configuration\Options;
use Brotkrueml\CodeHighlight\Configuration\SiteConfiguration;
use Brotkrueml\CodeHighlight\Event\EnrichCodeSnippetEvent;
use Brotkrueml\CodeHighlight\Extension;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Core\Attribute\AsAllowedCallable;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * @internal
 */
#[Autoconfigure(public: true)]
final class CodeSnippetGenerator
{
    private const PRE_ID_PREFIX = 'codesnippet';
    private const DEFAULT_THEME = Extension::PRISM_BASE_PATH . 'themes/prism.css';

    private ContentObjectRenderer $cObj;

    public function __construct(
        private readonly EventDispatcher $eventDispatcher,
        private readonly FlexFormService $flexFormService,
        private readonly PageRenderer $pageRenderer,
    ) {}

    public function setContentObjectRenderer(ContentObjectRenderer $cObj): void
    {
        $this->cObj = $cObj;
    }

    /**
     * @param array{} $conf
     */
    #[AsAllowedCallable]
    public function generate(
        string $content,
        array $conf,
        ServerRequestInterface $request,
    ): string {
        $snippet = $this->cObj->data['bodytext'] ?? '';
        if ($snippet === '') {
            return '';
        }

        $siteConfiguration = new SiteConfiguration($request->getAttribute('site')->getConfiguration());

        $this->addCssFile($siteConfiguration->theme ?: self::DEFAULT_THEME);
        $this->addJsFile(Extension::PRISM_BASE_PATH . 'components/prism-core.min.js');
        $this->addJsFile(Extension::PRISM_BASE_PATH . 'plugins/autoloader/prism-autoloader.min.js', false);

        $options = new Options($this->flexFormService->convertFlexFormContentToArray($this->cObj->data['pi_flexform'] ?? ''));

        $event = new EnrichCodeSnippetEvent(
            $siteConfiguration,
            $options,
            new AssetCollector(),
            new AssetCollector(),
            new TagAttributesCollector(),
            new TagAttributeValuesCollector(),
            new TagAttributesCollector(),
            new TagAttributeValuesCollector(),
            $request,
        );
        $event->preAttributesCollector->setAttribute('id', self::PRE_ID_PREFIX . $this->cObj->data['uid']);

        /** @var EnrichCodeSnippetEvent $event */
        $event = $this->eventDispatcher->dispatch($event);

        foreach ($event->stylesCollector->getPaths() as $path) {
            $this->addCssFile($path);
        }
        foreach ($event->scriptsCollector->getPaths() as $path) {
            $this->addJsFile($path);
        }

        $preClasses = (string) $event->preClassesCollector;
        if ($preClasses !== '') {
            $event->preAttributesCollector->setAttribute('class', $preClasses);
        }

        $codeClasses = (string) $event->codeClassesCollector;
        if ($codeClasses !== '') {
            $event->codeAttributesCollector->setAttribute('class', $codeClasses);
        }

        return '<pre ' . $event->preAttributesCollector . '>'
            . '<code ' . $event->codeAttributesCollector . '>'
            . \htmlspecialchars((string) $snippet)
            . '</code>'
            . '</pre>';
    }

    private function addCssFile(string $file): void
    {
        $this->pageRenderer->addCssFile($file);
    }

    private function addJsFile(string $file, bool $allowConcatenation = true): void
    {
        if ($allowConcatenation) {
            $this->pageRenderer->addJsFooterFile($file);
            return;
        }

        $this->pageRenderer->addJsFooterFile(
            $file,
            '',
            false,
            false,
            '',
            true,
        );
    }
}
