<?php
defined('TYPO3_MODE') or die();

(function($extensionKey) {
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Imaging\IconRegistry::class
    );

    $iconRegistry->registerIcon(
        'content-codehighlight',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:' . $extensionKey . '/Resources/Public/Icons/content-codehighlight.svg']
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '@import "EXT:' . $extensionKey . '/Configuration/TsConfig/Page/"'
    );
})('codehighlight');
