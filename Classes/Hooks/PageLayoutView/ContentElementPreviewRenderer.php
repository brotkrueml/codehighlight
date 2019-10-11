<?php
declare(strict_types = 1);

namespace Brotkrueml\CodeHighlight\Hooks\PageLayoutView;

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class ContentElementPreviewRenderer implements PageLayoutViewDrawItemHookInterface
{
    private const LL_PREFIX_CE = 'LLL:EXT:codehighlight/Resources/Private/Language/ContentElement.xlf:';
    private const LL_PREFIX_LANG = 'LLL:EXT:codehighlight/Resources/Private/Language/ProgrammingLanguages.xlf:';

    private $flexFormData;
    private $row;

    private $languageService;

    public function __construct(LanguageService $languageService = null)
    {
        $this->languageService = $languageService ?? $GLOBALS['LANG'];
    }

    public function preProcess(PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row)
    {
        if ($row['CType'] !== 'tx_codehighlight_codesnippet') {
            return;
        }

        $this->flexFormData = GeneralUtility::xml2array($row['pi_flexform']);
        $this->row = $row;

        $itemContent = $parentObject->linkEditContent($this->getContent(), $row);

        $drawItem = false;
    }

    private function getContent(): string
    {
        $content = $this->getHeader();

        if ($this->row['bodytext']) {
            $content .= '<pre><code>' . $this->renderText($this->row['bodytext']) . '</code></pre>';
        } else {
            $content .= $this->generateWarning(
                $this->languageService->sL(static::LL_PREFIX_CE . 'codeSnippet.notDefined')
            );
        }

        return $content;
    }

    private function getHeader(): string
    {
        $header = $this->languageService->sL(static::LL_PREFIX_CE . 'contentElement.title');

        $language = $this->getValueFromFlexform('programmingLanguage');

        if ($language) {
            $language = $this->languageService->sL(static::LL_PREFIX_LANG . $language) ?: $language;

            $header .= ' (' . $language . ')';
        }

        return '<strong>' . $header . '</strong>';
    }

    private function generateWarning(string $text): string
    {
        return '<br><br><div class="alert alert-warning">' . htmlspecialchars($text) . '</div>';
    }

    private function getValueFromFlexform(string $key, string $sheet = 'sDEF'): ?string
    {
        return $this->flexFormData['data'][$sheet]['lDEF'][$key]['vDEF'] ?? null;
    }

    private function renderText(string $input): string
    {
        $input = GeneralUtility::fixed_lgd_cs($input, 1500);

        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8', false);
    }
}
