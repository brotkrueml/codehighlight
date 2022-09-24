<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Service;

use Brotkrueml\CodeHighlight\Extension;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * @internal
 */
class TranslationService
{
    public function translate(string $key): string
    {
        return (string)LocalizationUtility::translate($key, Extension::KEY);
    }
}
