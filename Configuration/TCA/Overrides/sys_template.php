<?php
defined('TYPO3_MODE') or die();

(function ($extensionKey) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript/',
        'Code Highlight'
    );
})('codehighlight');
