<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\EventListener;

use Brotkrueml\CodeHighlight\Event\EnrichCodeSnippetEvent;
use Brotkrueml\CodeHighlight\Extension;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;

/**
 * @internal
 */
final class CopyToClipboard
{
    private LanguageServiceFactory $languageServiceFactory;

    public function __construct(LanguageServiceFactory $languageServiceFactory)
    {
        $this->languageServiceFactory = $languageServiceFactory;
    }

    public function __invoke(EnrichCodeSnippetEvent $event): void
    {
        if (! $event->siteConfiguration->toolbarCopyToClipboard) {
            return;
        }

        $event->stylesCollector->addPath(Extension::PRISM_BASE_PATH . 'plugins/toolbar/prism-toolbar.css');
        $event->scriptsCollector->addPath(Extension::PRISM_BASE_PATH . 'plugins/toolbar/prism-toolbar.min.js');
        $event->scriptsCollector->addPath(Extension::PRISM_BASE_PATH . 'plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js');

        $languageService = $this->languageServiceFactory->createFromSiteLanguage(
            $event->request->getAttribute('language') ?? $event->request->getAttribute('site')->getDefaultLanguage()
        );

        $event->preAttributesCollector->setAttribute('prismjs-copy', $languageService->sL('toolbar.copy'));
        $event->preAttributesCollector->setAttribute('prismjs-copy-error', $languageService->sL('toolbar.copyError'));
        $event->preAttributesCollector->setAttribute('prismjs-copy-success', $languageService->sL('toolbar.copySuccess'));
    }
}
