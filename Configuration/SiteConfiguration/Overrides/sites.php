<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\CodeHighlight\Extension;

$GLOBALS['SiteConfiguration']['site']['columns'] += [
    'codehighlightTheme' => [
        'label' => Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightTheme',
        'config' => [
            'type' => 'input',
            'eval' => 'trim',
            'valuePicker' => [
                'items' => [
                    [Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightTheme.valuePicker.default', Extension::PRISM_THEMES_PATH . 'prism.css'],
                    ['Coy', Extension::PRISM_THEMES_PATH . 'prism-coy.css'],
                    ['Dark', Extension::PRISM_THEMES_PATH . 'prism-dark.css'],
                    ['Funky', Extension::PRISM_THEMES_PATH . 'prism-funky.css'],
                    ['Okaidia', Extension::PRISM_THEMES_PATH . 'prism-okaidia.css'],
                    ['Solarized Light', Extension::PRISM_THEMES_PATH . 'prism-solarizedlight.css'],
                    ['Tomorrow Night', Extension::PRISM_THEMES_PATH . 'prism-tomorrow.css'],
                    ['Twilight', Extension::PRISM_THEMES_PATH . 'prism-twilight.css'],
                ],
            ],
        ],
    ],
    'codehighlightUseUrlHash' => [
        'label' => Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightUseUrlHash',
        'description' => Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightUseUrlHash.description',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'items' => [
                [
                    'label' => '',
                    'value' => '',
                ],
            ],
        ],
    ],
    'codehighlightCommandLineDefaultHost' => [
        'label' => Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightCommandLineDefaultHost',
        'config' => [
            'type' => 'input',
            'eval' => 'trim',
        ],
    ],
    'codehighlightCommandLineDefaultUser' => [
        'label' => Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightCommandLineDefaultUser',
        'config' => [
            'type' => 'input',
            'eval' => 'trim',
        ],
    ],
    'codehighlightToolbarCopyToClipboard' => [
        'label' => Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightToolbarCopyToClipboard',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'items' => [
                [
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
        --palette--;' . Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightCommandLine;codehighlightCommandLine,
        --palette--;' . Extension::LANGUAGE_PATH_SITE_CONFIGURATION . ':codehighlightToolbar;codehighlightToolbar,
';

$GLOBALS['SiteConfiguration']['site']['palettes'] += [
    'codehighlightCommandLine' => [
        'showitem' => 'codehighlightCommandLineDefaultHost,codehighlightCommandLineDefaultUser',
    ],
    'codehighlightToolbar' => [
        'showitem' => 'codehighlightToolbarCopyToClipboard',
    ],
];
