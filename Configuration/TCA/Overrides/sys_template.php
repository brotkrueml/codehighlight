<?php

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

defined('TYPO3') or die();

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    Brotkrueml\CodeHighlight\Extension::KEY,
    'Configuration/TypoScript/',
    'Code Highlight'
);
