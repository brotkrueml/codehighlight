<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

$GLOBALS['SiteConfiguration']['site']['columns'] += [
    'codehighlightTheme' => [
        'label' => Brotkrueml\CodeHighlight\Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightTheme',
        'config' => [
            'type' => 'input',
            'eval' => 'trim',
            'valuePicker' => [
                'items' => [
                    [Brotkrueml\CodeHighlight\Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightTheme.valuePicker.default', Brotkrueml\CodeHighlight\Extension::PRISM_THEMES_PATH . 'prism.css'],
                    ['Coy', Brotkrueml\CodeHighlight\Extension::PRISM_THEMES_PATH . 'prism-coy.css'],
                    ['Dark', Brotkrueml\CodeHighlight\Extension::PRISM_THEMES_PATH . 'prism-dark.css'],
                    ['Funky', Brotkrueml\CodeHighlight\Extension::PRISM_THEMES_PATH . 'prism-funky.css'],
                    ['Okaidia', Brotkrueml\CodeHighlight\Extension::PRISM_THEMES_PATH . 'prism-okaidia.css'],
                    ['Solarized Light', Brotkrueml\CodeHighlight\Extension::PRISM_THEMES_PATH . 'prism-solarizedlight.css'],
                    ['Tomorrow Night', Brotkrueml\CodeHighlight\Extension::PRISM_THEMES_PATH . 'prism-tomorrow.css'],
                    ['Twilight', Brotkrueml\CodeHighlight\Extension::PRISM_THEMES_PATH . 'prism-twilight.css'],
                ],
            ],
        ],
    ],
    'codehighlightUseUrlHash' => [
        'label' => Brotkrueml\CodeHighlight\Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightUseUrlHash',
        'description' => Brotkrueml\CodeHighlight\Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightUseUrlHash.description',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'items' => [
                [
                    0 => '',
                    1 => '',
                    'label' => '',
                    'value' => '',
                ],
            ],
        ],
    ],
    'codehighlightCommandLineDefaultHost' => [
        'label' => Brotkrueml\CodeHighlight\Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightCommandLineDefaultHost',
        'config' => [
            'type' => 'input',
            'eval' => 'trim',
        ],
    ],
    'codehighlightCommandLineDefaultUser' => [
        'label' => Brotkrueml\CodeHighlight\Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightCommandLineDefaultUser',
        'config' => [
            'type' => 'input',
            'eval' => 'trim',
        ],
    ],
    'codehighlightToolbarCopyToClipboard' => [
        'label' => Brotkrueml\CodeHighlight\Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightToolbarCopyToClipboard',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'items' => [
                [
                    0 => '',
                    1 => '',
                    'label' => '',
                    'value' => '',
                ],
            ],
        ],
    ],
];

$GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] .= '
    ,
    --div--;Code Highlight,
        codehighlightTheme,
        codehighlightUseUrlHash,
        --palette--;' . Brotkrueml\CodeHighlight\Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightCommandLine;codehighlightCommandLine,
        --palette--;' . Brotkrueml\CodeHighlight\Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightToolbar;codehighlightToolbar,
';

$GLOBALS['SiteConfiguration']['site']['palettes'] += [
    'codehighlightCommandLine' => [
        'showitem' => 'codehighlightCommandLineDefaultHost,codehighlightCommandLineDefaultUser',
    ],
    'codehighlightToolbar' => [
        'showitem' => 'codehighlightToolbarCopyToClipboard',
    ],
];
