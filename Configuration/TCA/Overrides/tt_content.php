<?php

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\CodeHighlight\Extension;
use Brotkrueml\CodeHighlight\Preview\ContentPreviewRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die();

(static function (): void {
    $contentType = 'tx_codehighlight_codesnippet';

    ExtensionManagementUtility::addPlugin(
        [
            Extension::LANGUAGE_PATH_CONTENT_ELEMENT . ':contentElement.title',
            $contentType,
            'EXT:' . Extension::KEY . '/Resources/Public/Icons/content-codehighlight.svg',
            'special',
        ],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
        Extension::KEY
    );

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$contentType] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:' . Extension::KEY . '/Configuration/FlexForms/Options.xml',
        $contentType
    );

    $GLOBALS['TCA']['tt_content']['types'][$contentType] = [
        'previewRenderer' => ContentPreviewRenderer::class,
        'columnsOverrides' => [
            'bodytext' => [
                'label' => Extension::LANGUAGE_PATH_CONTENT_ELEMENT . ':codeSnippet',
                'config' => [
                    'enableTabulator' => true,
                    'fixedFont' => true,
                    'wrap' => 'off',
                ],
            ],
            'pi_flexform' => [
                'label' => Extension::LANGUAGE_PATH_CONTENT_ELEMENT . ':options',
            ],
        ],
        'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;;general,
                    --palette--;;headers,
                    bodytext,
                --div--;' . Extension::LANGUAGE_PATH_CONTENT_ELEMENT . ':options,
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

    if (ExtensionManagementUtility::isLoaded('t3editor')) {
        $GLOBALS['TCA']['tt_content']['types'][$contentType]['columnsOverrides']['bodytext']['config']['renderType'] = 't3editor';
    }

    $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes'][$contentType] = 'content-codehighlight';
})();
