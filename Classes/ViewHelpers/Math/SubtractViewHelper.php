<?php
declare(strict_types = 1);

namespace Brotkrueml\CodeHighlight\ViewHelpers\Math;

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper;

/**
 * @internal
 */
class SubtractViewHelper extends ViewHelper\AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('subtrahend', 'string', 'Subtrahend', true);
        $this->registerArgument('minuend', 'string', 'Minuend', true);
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        if (!\is_numeric($arguments['subtrahend'])) {
            return $arguments['subtrahend'];
        }

        if (!\is_numeric($arguments['minuend'])) {
            return $arguments['subtrahend'];
        }

        $subtrahend = (int)$arguments['subtrahend'];
        $minuend = (int)$arguments['minuend'];

        return $subtrahend - $minuend;
    }
}
