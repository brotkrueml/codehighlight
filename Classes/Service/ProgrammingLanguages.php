<?php
declare(strict_types = 1);

namespace Brotkrueml\CodeHighlight\Service;

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Localization\LanguageService;

final class ProgrammingLanguages
{
    private const LL_PREFIX = 'LLL:EXT:codehighlight/Resources/Private/Language/ProgrammingLanguages.xlf:';

    public function getTcaItems(array &$config): void
    {
        $config['items'] = [
            ['', ''],
        ];

        $availableLanguages = $this->getAvailableProgrammingLanguages();
        $languageService = $this->getLanguageService();

        foreach ($availableLanguages as $language) {
            $config['items'][] = [
                $languageService->sL(static::LL_PREFIX . $language) ?: $language,
                $language
            ];
        }

        \usort($config['items'], function (array $a, array $b): int {
            $aci = \str_replace('.', '', \strtolower($a[0]));
            $bci = \str_replace('.', '', \strtolower($b[0]));

            return $aci <=> $bci;
        });
    }

    private function getAvailableProgrammingLanguages(): array
    {
        $path = __DIR__ . '/../../Resources/Private/PHP/AvailableProgrammingLanguages.php';
        if (\file_exists($path)) {
            return require $path;
        }

        return [];
    }

    private function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
