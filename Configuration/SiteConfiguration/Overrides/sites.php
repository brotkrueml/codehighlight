<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

(static function ($extensionKey) {
    $llPrefix = 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/SiteConfiguration.xlf:';
    $themePath = 'EXT:' . $extensionKey . '/Resources/Public/Prism/themes/';

    $GLOBALS['SiteConfiguration']['site']['columns'] += [
        'codehighlightTheme' => [
            'label' => $llPrefix . 'codehighlightTheme',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'valuePicker' => [
                    'items' => [
                        [$llPrefix . 'codehighlightTheme.valuePicker.default', $themePath . 'prism.css'],
                        ['Coy', $themePath . 'prism-coy.css'],
                        ['Dark', $themePath . 'prism-dark.css'],
                        ['Funky', $themePath . 'prism-funky.css'],
                        ['Okaidia', $themePath . 'prism-okaidia.css'],
                        ['Solarized Light', $themePath . 'prism-solarizedlight.css'],
                        ['Tomorrow Night', $themePath . 'prism-tomorrow.css'],
                        ['Twilight', $themePath . 'prism-twilight.css'],
                    ],
                ],
            ],
        ],
        'codehighlightUseUrlHash' => [
            'label' => $llPrefix . 'codehighlightUseUrlHash',
            'description' => $llPrefix . 'codehighlightUseUrlHash.description',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                    ],
                ],
            ],
        ],
        'codehighlightCommandLineDefaultHost' => [
            'label' => $llPrefix . 'codehighlightCommandLineDefaultHost',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'codehighlightCommandLineDefaultUser' => [
            'label' => $llPrefix . 'codehighlightCommandLineDefaultUser',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
    ];

    $GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] .= '
        ,
        --div--;Code Highlight,
            codehighlightTheme,
            codehighlightUseUrlHash,
            --palette--;' . $llPrefix . 'codehighlightCommandLine;codehighlightCommandLine,
    ';

    $GLOBALS['SiteConfiguration']['site']['palettes'] += [
        'codehighlightCommandLine' => [
            'showitem' => 'codehighlightCommandLineDefaultHost,codehighlightCommandLineDefaultUser',
        ],
    ];
})('codehighlight');
