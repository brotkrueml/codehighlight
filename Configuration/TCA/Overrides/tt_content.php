<?php
defined('TYPO3_MODE') or die();

(function ($extensionKey, $contentType) {
    $llPrefix = 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/ContentElement.xlf:';

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
        [
            $llPrefix . 'contentElement.title',
            $contentType,
            'EXT:' . $extensionKey . '/Resources/Public/Icons/content-codehighlight.svg',
        ],
        'CType',
        $extensionKey
    );

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$contentType] = 'pi_flexform';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:' . $extensionKey . '/Configuration/FlexForms/Options.xml',
        $contentType
    );

    $tempTypes = [
        $contentType => [
            'columnsOverrides' => [
                'bodytext' => [
                    'label' => $llPrefix . 'codeSnippet',
                    'config' => [
                        'enableTabulator' => true,
                        'fixedFont' => true,
                        'wrap' => 'off',
                    ],
                ],
                'pi_flexform' => [
                    'label' => $llPrefix . 'options',
                ]
            ],
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;;general,
                    --palette--;;headers,
                    bodytext,
                --div--;' . $llPrefix . 'options,
                    pi_flexform,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                    --palette--;;frames,
                    --palette--;;appearanceLinks,
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
        $tempTypes[$contentType]['columnsOverrides']['bodytext']['config']['renderType'] = 't3editor';
    }

    $GLOBALS['TCA']['tt_content']['types'] += $tempTypes;
})('codehighlight', 'tx_codehighlight_codesnippet');
