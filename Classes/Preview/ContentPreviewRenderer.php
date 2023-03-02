<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Preview;

use Brotkrueml\CodeHighlight\Extension;
use TYPO3\CMS\Backend\Preview\StandardContentPreviewRenderer;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Service\FlexFormService;

/**
 * @internal
 */
final class ContentPreviewRenderer extends StandardContentPreviewRenderer
{
    private const MAX_CODE_SNIPPET_LINES = 20;

    private FlexFormService $flexFormService;

    public function __construct(FlexFormService $flexFormService)
    {
        $this->flexFormService = $flexFormService;
    }

    public function renderPageModulePreviewContent(GridColumnItem $item): string
    {
        $content = '';
        if ((new Typo3Version())->getMajorVersion() < 12) {
            $content = '<strong>'
                . $this->renderText($this->getLanguageService()->sL(Extension::LANGUAGE_PATH_CONTENT_ELEMENT . ':contentElement.title'))
                . '</strong>'
                . '<br>';
        }

        $record = $item->getRecord();
        if ($record['bodytext']) {
            $content .= '<pre><code style="margin-left:0;">' . $this->renderSnippet($record['bodytext']) . '</code></pre>';
        } else {
            $content .= $this->buildWarning(
                $this->getLanguageService()->sL(Extension::LANGUAGE_PATH_CONTENT_ELEMENT . ':codeSnippet.notDefined')
            );
        }

        return $this->linkEditContent($content, $record);
    }

    public function renderPageModulePreviewFooter(GridColumnItem $item): string
    {
        $record = $item->getRecord();
        $settings = $this->getFlexFormSettings($record['pi_flexform']);

        $footer = [];
        if (($settings['programmingLanguage'] ?? '') !== '') {
            $footer[] = $this->getLanguageService()->sL(Extension::LANGUAGE_PATH_PROGRAMMING_LANGUAGES . ':' . $settings['programmingLanguage'])
                ?: $settings['programmingLanguage'];
        }
        if (($settings['filename'] ?? '') !== '') {
            $footer[] = $settings['filename'];
        }

        return \implode('<br>', $footer);
    }

    private function renderSnippet(string $input): string
    {
        $lines = \preg_split("/\R/", $input);
        if ($lines === false) {
            return $this->treatSpecialChars($input);
        }

        $slicedLines = \array_slice($lines, 0, self::MAX_CODE_SNIPPET_LINES);
        $output = \implode("\r\n", $slicedLines);
        if (\count($lines) !== \count($slicedLines)) {
            $output .= "\r\n\r\n...";
        }

        return $this->treatSpecialChars($output);
    }

    private function treatSpecialChars(string $input): string
    {
        return \htmlspecialchars(\trim($input), ENT_QUOTES, 'UTF-8', false);
    }

    private function buildWarning(string $text): string
    {
        return '<br><div class="alert alert-warning">' . \htmlspecialchars($text) . '</div>';
    }

    /**
     * @return array<string, string>
     */
    private function getFlexFormSettings(string $flexFormXml): array
    {
        return $this->flexFormService->convertFlexFormContentToArray($flexFormXml);
    }
}
