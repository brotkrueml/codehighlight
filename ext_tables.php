<?php

use Brotkrueml\CodeHighlight\Extension;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

if ((new Typo3Version())->getMajorVersion() < 12) {
    ExtensionManagementUtility::addPageTSConfig(
        '@import "EXT:' . Extension::KEY . '/Configuration/TsConfig/Page/*.tsconfig"'
    );
}
