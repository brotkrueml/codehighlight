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
final class LineNumbers
{
    public function __invoke(EnrichCodeSnippetEvent $event): void
    {
        if (! $event->options->showLineNumbers) {
            return;
        }

        $event->preClassesCollector->addValue('line-numbers');
        $event->stylesCollector->addPath(Extension::PRISM_BASE_PATH . 'plugins/line-numbers/prism-line-numbers.css');
        $event->scriptsCollector->addPath(Extension::PRISM_BASE_PATH . 'plugins/line-numbers/prism-line-numbers.min.js');

        if ($event->options->startWithLineNumber > 1) {
            $event->preAttributesCollector->setAttribute('start', (string) $event->options->startWithLineNumber);
        }
    }
}
