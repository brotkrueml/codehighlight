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
use TYPO3\CMS\Core\Attribute\AsEventListener;

/**
 * @internal
 */
#[AsEventListener(
    identifier: 'codehighlight/language',
)]
final readonly class Language
{
    public function __invoke(EnrichCodeSnippetEvent $event): void
    {
        if ($event->hasSpecialLanguage) {
            return;
        }

        $language = $event->options->programmingLanguage ?: 'none';

        $event->codeClassesCollector->addValue('language-' . $language);
    }
}
