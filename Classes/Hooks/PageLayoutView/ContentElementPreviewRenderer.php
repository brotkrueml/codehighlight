<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Hooks\PageLayoutView;

use Brotkrueml\CodeHighlight\Extension;
use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @internal
 */
final class ContentElementPreviewRenderer implements PageLayoutViewDrawItemHookInterface
{
    /**
     * @var array<string, array|string|int|null>|null
     * @noRector TypedPropertyFromAssignsRector
     */
    private $flexFormData;
    /**
     * @var array<string, string|int|null>|null
     * @noRector TypedPropertyFromAssignsRector
     */
    private $row;
    /**
     * @var LanguageService
     * @noRector TypedPropertyFromAssignsRector
     */
    private $languageService;

    public function __construct(LanguageService $languageService = null)
    {
        $this->languageService = $languageService ?? $GLOBALS['LANG'];
    }

    public function preProcess(PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row): void
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
            $content .= '<pre><code style="margin-left:0;">' . $this->renderText($this->row['bodytext']) . '</code></pre>';
        } else {
            $content .= $this->generateWarning(
                $this->languageService->sL(Extension::LANGUAGE_PATH_CONTENT_ELEMENT . ':codeSnippet.notDefined')
            );
        }

        return $content;
    }

    private function getHeader(): string
    {
        $header = $this->languageService->sL(Extension::LANGUAGE_PATH_CONTENT_ELEMENT . ':contentElement.title');

        $language = $this->getValueFromFlexform('programmingLanguage');
        $filename = $this->getValueFromFlexform('filename');

        $additionalHeaderInfo = [];

        if ($language) {
            $additionalHeaderInfo[] = $this->languageService->sL(Extension::LANGUAGE_PATH_PROGRAMMING_LANGUAGES . ':' . $language) ?: $language;
        }

        if ($filename) {
            $additionalHeaderInfo[] = $filename;
        }

        if ($additionalHeaderInfo) {
            $header .= ' (' . \implode(', ', $additionalHeaderInfo) . ')';
        }

        return '<strong>' . \htmlspecialchars($header) . '</strong>';
    }

    private function generateWarning(string $text): string
    {
        return '<br><br><div class="alert alert-warning">' . \htmlspecialchars($text) . '</div>';
    }

    private function getValueFromFlexform(string $key, string $sheet = 'sDEF'): ?string
    {
        return $this->flexFormData['data'][$sheet]['lDEF'][$key]['vDEF'] ?? null;
    }

    private function renderText(string $input): string
    {
        $input = GeneralUtility::fixed_lgd_cs($input, 1500);

        return \htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8', false);
    }
}
