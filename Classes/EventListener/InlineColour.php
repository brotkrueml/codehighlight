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
use TYPO3\CMS\Core\Attribute\AsEventListener;

/**
 * @internal
 */
#[AsEventListener(
    identifier: 'codehighlight/inline-colour',
)]
final readonly class InlineColour
{
    public function __invoke(EnrichCodeSnippetEvent $event): void
    {
        if (! $event->options->inlineColour) {
            return;
        }

        if (! \in_array($event->options->programmingLanguage, ['css', 'html'], true)) {
            return;
        }

        $event->stylesCollector->addPath(Extension::PRISM_BASE_PATH . 'plugins/inline-color/prism-inline-color.css');
        $event->scriptsCollector->addPath(Extension::PRISM_BASE_PATH . 'components/prism-css.min.js');
        $event->scriptsCollector->addPath(Extension::PRISM_BASE_PATH . 'components/prism-css-extras.min.js');
        $event->scriptsCollector->addPath(Extension::PRISM_BASE_PATH . 'plugins/inline-color/prism-inline-color.min.js');
    }
}
