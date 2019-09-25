<?php
declare(strict_types = 1);

namespace Brotkrueml\CodeHighlight\ViewHelpers\Asset;

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

class StyleViewHelper extends AbstractViewHelper
{
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): void {
        $pageRenderer = static::getPageRenderer();

        $pageRenderer->addCssFile($arguments['path']);
    }
}
