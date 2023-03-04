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
final class CommandLine
{
    public function __invoke(EnrichCodeSnippetEvent $event): void
    {
        if (! $event->options->displayCommandLine) {
            return;
        }

        $event->preClassesCollector->addValue('command-line');
        $event->stylesCollector->addPath(Extension::PRISM_BASE_PATH . 'plugins/command-line/prism-command-line.css');
        $event->scriptsCollector->addPath(Extension::PRISM_BASE_PATH . 'plugins/command-line/prism-command-line.min.js');

        $preAttributesCollector = $event->preAttributesCollector;

        if ($event->options->commandLineOutputLines !== '') {
            $preAttributesCollector->setAttribute('data-output', $event->options->commandLineOutputLines);
        }

        if ($event->options->commandLineOutputFilter !== '') {
            $preAttributesCollector->setAttribute('data-filter-output', $event->options->commandLineOutputFilter);
        }

        if ($event->options->commandLineServerPrompt !== '') {
            $preAttributesCollector->setAttribute('data-prompt', $event->options->commandLineServerPrompt);
        }

        $commandLineUser = $event->options->commandLineServerUser !== ''
            ? $event->options->commandLineServerUser
            : $event->siteConfiguration->commandLineDefaultUser;
        if ($commandLineUser !== '') {
            $preAttributesCollector->setAttribute('data-user', $commandLineUser);
        }

        $commandLineHost = $event->options->commandLineServerHost !== ''
            ? $event->options->commandLineServerHost
            : $event->siteConfiguration->commandLineDefaultHost;
        if ($commandLineHost !== '') {
            $preAttributesCollector->setAttribute('data-host', $commandLineHost);
        }
    }
}
