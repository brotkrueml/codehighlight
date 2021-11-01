<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\ViewHelpers;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper;

/**
 * The view helper injects the necessary CSS and JavaScript files
 * and returns the necessary HTML code.
 *
 * Example:
 *
 * <codeHighlight:prism
 *     configuration="{site.configuration}"
 *     options="{options}"
 *     settings="{settings}"
 *     id="codesnippet{data.uid}"
 *     snippet="{data.bodytext}"
 * />
 */
class PrismViewHelper extends ViewHelper\AbstractViewHelper
{
    private const PRISM_PATH = 'EXT:codehighlight/Resources/Public/Prism/';

    protected $escapeOutput = false;

    /**
     * @var PageRenderer
     */
    private static $pageRenderer;

    private static $configuration;
    private static $options;
    private static $id;
    private static $snippet;

    private static $preAttributes;
    private static $preClasses;
    private static $codeClasses;

    public function initializeArguments(): void
    {
        $this->registerArgument('configuration', 'array', 'Configuration (from site configuration)', false, []);
        $this->registerArgument('options', 'array', 'Options (from flexform)', false, []);
        $this->registerArgument('id', 'string', 'id attribute of the surrounding tag', false, '');
        $this->registerArgument('snippet', 'string', 'Code snippet', false, '');
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string {
        static::initialisePageRenderer();

        static::$configuration = $arguments['configuration'] ?? [];
        static::$options = $arguments['options'] ?? [];
        static::$id = $arguments['id'] ?? '';
        static::$snippet = $arguments['snippet'] ?? '';

        if (empty(static::$snippet)) {
            return '';
        }

        static::$preAttributes = [];
        static::$preClasses = [];
        static::$codeClasses = [];

        static::handleMainAssets();
        static::handleLineNumbers();
        static::handleCommandLine();
        static::handleInlineColour();
        static::handleProgrammingLanguage();

        return static::buildHtml();
    }

    private static function handleMainAssets(): void
    {
        $theme = static::$configuration['codehighlightTheme'] ?? '';
        if ($theme) {
            static::addCssFile($theme, false);
        } else {
            static::addCssFile('themes/prism.css');
        }

        static::addJsFile('components/prism-core.min.js');
        static::addJsFile('plugins/autoloader/prism-autoloader.min.js');
    }

    private static function handleLineNumbers(): void
    {
        if (static::$options['showLineNumbers'] ?? false) {
            static::$preClasses[] = 'line-numbers';
            static::addCssFile('plugins/line-numbers/prism-line-numbers.css');
            static::addJsFile('plugins/line-numbers/prism-line-numbers.min.js');

            if (static::$options['startWithLineNumber'] ?? false) {
                static::addToPreAttributes('start', static::$options['startWithLineNumber']);
            }
        }

        if ((static::$options['highlightLines'] ?? false) || (static::$configuration['codehighlightUseUrlHash'] ?? false)) {
            static::addCssFile('plugins/line-highlight/prism-line-highlight.css');
            static::addJsFile('plugins/line-highlight/prism-line-highlight.min.js');
        }

        if (static::$options['highlightLines'] ?? false) {
            static::addToPreAttributes('line', static::$options['highlightLines']);

            if (\is_numeric(static::$options['startWithLineNumber'] ?? '')) {
                static::addToPreAttributes('line-offset', (string)((int)static::$options['startWithLineNumber'] - 1));
            }
        }
    }

    private static function handleCommandLine(): void
    {
        if (! (static::$options['displayCommandLine'] ?? false)) {
            return;
        }

        static::$preClasses[] = 'command-line';
        static::addCssFile('plugins/command-line/prism-command-line.css');
        static::addJsFile('plugins/command-line/prism-command-line.min.js');

        if (static::$options['commandLineOutputLines'] ?? false) {
            static::addToPreAttributes('output', static::$options['commandLineOutputLines']);
        }

        if (static::$options['commandLineOutputFilter'] ?? false) {
            static::addToPreAttributes('filter-output', static::$options['commandLineOutputFilter']);
        }

        if (static::$options['commandLineServerPrompt'] ?? false) {
            static::addToPreAttributes('prompt', static::$options['commandLineServerPrompt']);
            return;
        }

        if (static::$options['commandLineServerUser'] ?? false) {
            static::addToPreAttributes('user', static::$options['commandLineServerUser']);
        } elseif (static::$configuration['codehighlightCommandLineDefaultUser'] ?? false) {
            static::addToPreAttributes('user', static::$configuration['codehighlightCommandLineDefaultUser']);
        }

        if (static::$options['commandLineServerHost'] ?? false) {
            static::addToPreAttributes('host', static::$options['commandLineServerHost']);
        } elseif (static::$configuration['codehighlightCommandLineDefaultHost'] ?? false) {
            static::addToPreAttributes('host', static::$configuration['codehighlightCommandLineDefaultHost']);
        }
    }

    private static function handleInlineColour(): void
    {
        if (! (static::$options['inlineColour'] ?? false)) {
            return;
        }

        if (! \in_array(static::$options['programmingLanguage'], ['css', 'html'], true)) {
            return;
        }

        static::addCssFile('plugins/inline-color/prism-inline-color.css');
        static::addJsFile('plugins/inline-color/prism-inline-color.min.js');
        static::$codeClasses[] = 'language-css-extras';
    }

    private static function handleProgrammingLanguage(): void
    {
        $programmingLanguage = static::$options['programmingLanguage'] ?? '';

        static::$codeClasses[] = \sprintf(
            'language-%s',
            \htmlspecialchars($programmingLanguage) ?: 'none'
        );
    }

    private static function buildHtml(): string
    {
        if (! empty(static::$preClasses)) {
            static::$preAttributes[] = \sprintf(
                'class="%s"',
                \implode(' ', static::$preClasses)
            );
        }

        $preAttributes = \implode(' ', static::$preAttributes);

        $codeAttributes = '';
        if (! empty(static::$codeClasses)) {
            $codeAttributes = \sprintf(
                'class="%s"',
                \implode(' ', static::$codeClasses)
            );
        }

        $id = static::$id ? \sprintf(' id="%s"', static::$id) : '';

        return \sprintf(
            '<pre%s%s><code%s>%s</code></pre>',
            $id,
            $preAttributes ? ' ' . $preAttributes : '',
            $codeAttributes ? ' ' . $codeAttributes : '',
            \htmlspecialchars(static::$snippet)
        );
    }

    private static function initialisePageRenderer(): void
    {
        if (static::$pageRenderer === null) {
            static::$pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        }
    }

    private static function addCssFile(string $file, bool $prependPrismPath = true): void
    {
        if ($prependPrismPath) {
            static::$pageRenderer->addCssFile(static::PRISM_PATH . $file);
        } else {
            static::$pageRenderer->addCssFile($file);
        }
    }

    private static function addJsFile(string $file): void
    {
        static::$pageRenderer->addJsFooterFile(static::PRISM_PATH . $file);
    }

    private static function addToPreAttributes(string $dataName, string $dataValue): void
    {
        static::$preAttributes[] = \sprintf(
            'data-%s="%s"',
            $dataName,
            \htmlspecialchars($dataValue)
        );
    }

    /**
     * For testing purposes only!
     */
    public static function setPageRenderer(PageRenderer $pageRenderer): void
    {
        static::$pageRenderer = $pageRenderer;
    }
}
