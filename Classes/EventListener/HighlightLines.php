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

/**
 * @internal
 */
final class HighlightLines
{
    public function __invoke(EnrichCodeSnippetEvent $event): void
    {
        if (($event->options->highlightLines !== '') || $event->siteConfiguration->useUrlHash) {
            $event->stylesCollector->addPath(Extension::PRISM_BASE_PATH . 'plugins/line-highlight/prism-line-highlight.css');
            $event->scriptsCollector->addPath(Extension::PRISM_BASE_PATH . 'plugins/line-highlight/prism-line-highlight.min.js');
        }

        if ($event->options->highlightLines !== '') {
            $event->preAttributesCollector->setAttribute('data-line', $event->options->highlightLines);

            if ($event->options->startWithLineNumber > 1) {
                $event->preAttributesCollector->setAttribute('data-line-offset', (string) ($event->options->startWithLineNumber - 1));
            }
        }
    }
}
