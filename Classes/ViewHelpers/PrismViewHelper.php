<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\ViewHelpers;

use Brotkrueml\CodeHighlight\Extension;
use Brotkrueml\CodeHighlight\Service\TranslationService;
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
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    private static ?PageRenderer $pageRenderer = null;
    private static ?TranslationService $translationService = null;

    /**
     * @var mixed|mixed[]|null
     */
    private static $configuration;
    /**
     * @var mixed|mixed[]|null
     */
    private static $options;
    /**
     * @var mixed|string|null
     */
    private static $id;
    /**
     * @var mixed|string|null
     */
    private static $snippet;

    /**
     * @var mixed[]|string[]|null
     */
    private static ?array $preAttributes = null;
    /**
     * @var mixed[]|string[]|null
     */
    private static ?array $preClasses = null;
    /**
     * @var mixed[]|string[]|null
     */
    private static ?array $codeClasses = null;

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

        if (static::$snippet === '') {
            return '';
        }

        static::$preAttributes = [];
        static::$preClasses = [];
        static::$codeClasses = [];

        static::handleMainAssets();
        static::handleLineNumbers();
        static::handleCommandLine();
        static::handleInlineColour();
        static::handleCopyToClipboard();
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
        static::addJsFile('plugins/autoloader/prism-autoloader.min.js', false);
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

    private static function handleCopyToClipboard(): void
    {
        if (! (static::$configuration['codehighlightToolbarCopyToClipboard'] ?? false)) {
            return;
        }

        static::addCssFile('plugins/toolbar/prism-toolbar.css');
        static::addJsFile('plugins/toolbar/prism-toolbar.min.js');
        static::addJsFile('plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js');

        static::addToPreAttributes('prismjs-copy', static::translate('toolbar.copy'));
        static::addToPreAttributes('prismjs-copy-error', static::translate('toolbar.copyError'));
        static::addToPreAttributes('prismjs-copy-success', static::translate('toolbar.copySuccess'));
    }

    private static function translate(string $key): string
    {
        if (static::$translationService === null) {
            static::$translationService = new TranslationService();
        }

        return static::$translationService->translate($key);
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
        if (static::$preClasses !== []) {
            static::$preAttributes[] = \sprintf(
                'class="%s"',
                \implode(' ', static::$preClasses)
            );
        }

        $preAttributes = \implode(' ', static::$preAttributes);

        $codeAttributes = '';
        if (static::$codeClasses !== []) {
            $codeAttributes = \sprintf(
                'class="%s"',
                \implode(' ', static::$codeClasses)
            );
        }

        $id = static::$id ? \sprintf(' id="%s"', static::$id) : '';

        return \sprintf(
            '<pre%s%s><code%s>%s</code></pre>',
            $id,
            $preAttributes !== '' ? ' ' . $preAttributes : '',
            $codeAttributes !== '' ? ' ' . $codeAttributes : '',
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
            static::$pageRenderer->addCssFile(Extension::PRISM_BASE_PATH . $file);
        } else {
            static::$pageRenderer->addCssFile($file);
        }
    }

    private static function addJsFile(string $file, bool $allowConcatenation = true): void
    {
        if ($allowConcatenation) {
            static::$pageRenderer->addJsFooterFile(Extension::PRISM_BASE_PATH . $file);
            return;
        }

        static::$pageRenderer->addJsFooterFile(
            Extension::PRISM_BASE_PATH . $file,
            '',
            false,
            false,
            '',
            true
        );
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

    /**
     * For testing purposes only!
     */
    public static function setTranslationService(TranslationService $translationService): void
    {
        static::$translationService = $translationService;
    }
}
