<?php
defined('TYPO3_MODE') or die();

(function ($extensionKey='codehighlight') {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript/',
        'Code Highlight'
    );
})();
