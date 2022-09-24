<?php
defined('TYPO3') or die();

(static function() {
    if (! (new Brotkrueml\CodeHighlight\Compatibility\Compatibility())->hasIconsConfigurationFile()) {
        $iconRegistry = TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            TYPO3\CMS\Core\Imaging\IconRegistry::class
        );

        $iconRegistry->registerIcon(
            'content-codehighlight',
            TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:' . Brotkrueml\CodeHighlight\Extension::KEY . '/Resources/Public/Icons/content-codehighlight.svg']
        );
    }

    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '@import "EXT:' . Brotkrueml\CodeHighlight\Extension::KEY . '/Configuration/TSconfig/Page/*.tsconfig"'
    );

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['codehighlight'] =
        Brotkrueml\CodeHighlight\Hooks\PageLayoutView\ContentElementPreviewRenderer::class;
})();
