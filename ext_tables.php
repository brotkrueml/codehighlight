<?php
defined('TYPO3') || die();

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '@import "EXT:' . Brotkrueml\CodeHighlight\Extension::KEY . '/Configuration/TSconfig/Page/*.tsconfig"'
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['codehighlight'] =
    Brotkrueml\CodeHighlight\Hooks\PageLayoutView\ContentElementPreviewRenderer::class;
