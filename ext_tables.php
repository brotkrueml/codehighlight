<?php

use Brotkrueml\CodeHighlight\Extension;
use TYPO3\CMS\Core\Information\Typo3Version;

defined('TYPO3') || die();

if ((new Typo3Version())->getMajorVersion() < 12) {
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '@import "EXT:' . Extension::KEY . '/Configuration/TSconfig/Page/*.tsconfig"'
    );
}
