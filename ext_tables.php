<?php

use Brotkrueml\CodeHighlight\Extension;
use Brotkrueml\CodeHighlight\Hooks\PageLayoutView\ContentElementPreviewRenderer;
use TYPO3\CMS\Core\Information\Typo3Version;

defined('TYPO3') || die();

if ((new Typo3Version())->getMajorVersion() < 12) {
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '@import "EXT:' . Extension::KEY . '/Configuration/TSconfig/Page/*.tsconfig"'
    );
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['codehighlight'] =
    ContentElementPreviewRenderer::class;
