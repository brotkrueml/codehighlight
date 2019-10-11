<?php

(function ($extensionKey) {
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
                    ]
                ],
            ],
        ],
    ];

    $GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] .= '
        ,
        --div--;Code Highlight,
            codehighlightTheme,
            codehighlightUseUrlHash
    ';
})('codehighlight');
