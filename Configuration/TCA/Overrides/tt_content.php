<?php
defined('TYPO3_MODE') or die();

(function ($extensionKey, $type) {
    $llPrefix = 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/Database.xlf:';

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
        [
            $llPrefix . 'tt_content.CType.' . $type,
            $type,
            'EXT:' . $extensionKey . '/Resources/Public/Icons/content-codehighlight.svg',
        ],
        'CType',
        $extensionKey
    );

    $tempTypes = [
        $type => [
            'columnsOverrides' => [
                'bodytext' => [
                    'label' => $llPrefix . 'tt_content.bodytext',
                    'config' => [
                        'enableTabulator' => true,
                        'fixedFont' => true,
                        'wrap' => 'off',
                        'behaviour' => [
                            'allowLanguageSynchronization' => true,
                        ],
                    ],
                ],
            ],
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;;general,
                bodytext,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                --palette--;;language,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                --palette--;;hidden,
                --palette--;;access,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended
            ',
        ],
    ];

    if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('t3editor')) {
        $tempTypes[$type]['columnsOverrides']['bodytext']['config']['renderType'] = 't3editor';
    }

    $GLOBALS['TCA']['tt_content']['types'] += $tempTypes;
})('codehighlight', 'tx_codehighlight');
