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
final class Treeview
{
    public function __invoke(EnrichCodeSnippetEvent $event): void
    {
        if (! $event->options->treeview) {
            return;
        }

        $event->hasSpecialLanguage = true;
        $event->codeClassesCollector->addValue('language-treeview');
        $event->stylesCollector->addPath(Extension::PRISM_BASE_PATH . 'plugins/treeview/prism-treeview.css');
        $event->scriptsCollector->addPath(Extension::PRISM_BASE_PATH . 'plugins/treeview/prism-treeview.min.js');
    }
}
