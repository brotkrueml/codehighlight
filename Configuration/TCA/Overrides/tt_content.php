<?php

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

defined('TYPO3') || die();

(static function () {
    $contentType = 'tx_codehighlight_codesnippet';

    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
        [
            Brotkrueml\CodeHighlight\Extension::LANGUAGE_PATH_CONTENT_ELEMENT . ':contentElement.title',
            $contentType,
            'EXT:' . Brotkrueml\CodeHighlight\Extension::KEY . '/Resources/Public/Icons/content-codehighlight.svg',
            'special',
        ],
        TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
        Brotkrueml\CodeHighlight\Extension::KEY
    );

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$contentType] = 'pi_flexform';
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:' . Brotkrueml\CodeHighlight\Extension::KEY . '/Configuration/FlexForms/Options.xml',
        $contentType
    );

    $GLOBALS['TCA']['tt_content']['types'][$contentType] = [
        'previewRenderer' => Brotkrueml\CodeHighlight\Preview\ContentPreviewRenderer::class,
        'columnsOverrides' => [
            'bodytext' => [
                'label' => Brotkrueml\CodeHighlight\Extension::LANGUAGE_PATH_CONTENT_ELEMENT . ':codeSnippet',
                'config' => [
                    'enableTabulator' => true,
                    'fixedFont' => true,
                    'wrap' => 'off',
                ],
            ],
            'pi_flexform' => [
                'label' => Brotkrueml\CodeHighlight\Extension::LANGUAGE_PATH_CONTENT_ELEMENT . ':options',
            ],
        ],
        'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;;general,
                    --palette--;;headers,
                    bodytext,
                --div--;' . Brotkrueml\CodeHighlight\Extension::LANGUAGE_PATH_CONTENT_ELEMENT . ':options,
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
    ];

    if (TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('t3editor')) {
        $GLOBALS['TCA']['tt_content']['types'][$contentType]['columnsOverrides']['bodytext']['config']['renderType'] = 't3editor';
    }

    $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes'][$contentType] = 'content-codehighlight';
})();
