<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * @internal
 */
final class CropLinesViewHelper extends AbstractViewHelper
{
    private const MAX_LINES = 20;

    public function render(): string
    {
        $stringToTruncate = (string) $this->renderChildren();

        $lines = \preg_split('/\R/', $stringToTruncate);
        if ($lines === false) {
            return $stringToTruncate;
        }

        $slicedLines = \array_slice($lines, 0, self::MAX_LINES);
        $output = \implode("\r\n", $slicedLines);
        if (\count($lines) !== \count($slicedLines)) {
            $output .= "\r\n\r\n...";
        }

        return $output;
    }
}
