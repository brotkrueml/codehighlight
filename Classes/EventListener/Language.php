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

/**
 * @internal
 */
final class Language
{
    public function __invoke(EnrichCodeSnippetEvent $event): void
    {
        $language = $event->options->programmingLanguage ?: 'none';

        $event->codeClassesCollector->addValue('language-' . $language);
    }
}
