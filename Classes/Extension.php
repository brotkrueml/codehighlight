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

    public const CE_TYPE = 'tx_codehighlight_codesnippet';

    public const LANGUAGE_PATH_CONTENT_ELEMENT = 'LLL:EXT:' . self::KEY . '/Resources/Private/Language/ContentElement.xlf';
    public const LANGUAGE_PATH_PROGRAMMING_LANGUAGES = 'LLL:EXT:' . self::KEY . '/Resources/Private/Language/ProgrammingLanguages.xlf';
    public const LANGUAGE_PATH_SITE_CONFIGURATION = 'LLL:EXT:' . self::KEY . '/Resources/Private/Language/SiteConfiguration.xlf';

    public const PRISM_BASE_PATH = 'EXT:' . self::KEY . '/Resources/Public/Prism/';
    public const PRISM_THEMES_PATH = self::PRISM_BASE_PATH . 'themes/';
}
