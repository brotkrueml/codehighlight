<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight;

/**
 * @internal
 */
final class Extension
{
    public const KEY = 'codehighlight';

    public const LANGUAGE_PATH_CONTENT_ELEMENT = 'LLL:EXT:' . self::KEY . '/Resources/Private/Language/ContentElement.xlf';
}
