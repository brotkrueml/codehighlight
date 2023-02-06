<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Service;

use Brotkrueml\CodeHighlight\Extension;
use TYPO3\CMS\Core\Localization\LanguageService;

/**
 * @internal
 */
final class ProgrammingLanguages
{
    /**
     * @var LanguageService
     */
    private $languageService;

    public function __construct(LanguageService $languageService = null)
    {
        $this->languageService = $languageService ?? $GLOBALS['LANG'];
    }

    public function getTcaItems(array &$config): void
    {
        $config['items'] = [
            ['', ''],
        ];

        $availableLanguages = $this->getAvailableProgrammingLanguages();

        foreach ($availableLanguages as $language) {
            $config['items'][] = [
                $this->languageService->sL(Extension::LANGUAGE_PATH_PROGRAMMING_LANGUAGES . ':' . $language) ?: $language,
                $language,
            ];
        }

        \usort($config['items'], static function (array $a, array $b): int {
            $aci = \str_replace('.', '', \strtolower($a[0]));
            $bci = \str_replace('.', '', \strtolower($b[0]));

            return $aci <=> $bci;
        });
    }

    /**
     * @return list<string>
     */
    private function getAvailableProgrammingLanguages(): array
    {
        $path = __DIR__ . '/../../Resources/Private/PHP/AvailableProgrammingLanguages.php';
        if (\file_exists($path)) {
            $languages = require $path;

            return \array_merge($languages, $this->getAliases());
        }

        return [];
    }

    private function getAliases(): array
    {
        return [
            // @see components/prism-bash.js
            'shell',

            // @see components/prism-bnf.js
            'rbnf',

            // @see components/prism-markup.js
            'html',
            'mathml',
            'svg',
            'xml',
        ];
    }
}
