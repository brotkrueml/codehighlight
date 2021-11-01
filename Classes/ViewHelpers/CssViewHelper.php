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

class CssViewHelper extends ViewHelper\AbstractViewHelper
{
    /**
     * @var PageRenderer
     */
    private static $pageRenderer;

    public function initializeArguments(): void
    {
        $this->registerArgument('path', 'string', 'Path to css file', true);
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): void {
        if (empty($arguments['path'])) {
            return;
        }

        $pageRenderer = static::getPageRenderer();
        $pageRenderer->addCssFile($arguments['path']);
    }

    protected static function getPageRenderer(): PageRenderer
    {
        if (static::$pageRenderer === null) {
            return GeneralUtility::makeInstance(PageRenderer::class);
        }

        return static::$pageRenderer;
    }

    /**
     * For testing purposes only!
     */
    public static function setPageRenderer(PageRenderer $pageRenderer): void
    {
        static::$pageRenderer = $pageRenderer;
    }
}
