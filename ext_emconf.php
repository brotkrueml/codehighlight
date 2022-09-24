<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Code Highlight',
    'description' => 'Code highlighter for various programming, markup and configuration languages based on PrismJS',
    'category' => 'fe',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'author' => 'Chris Müller',
    'author_email' => 'typo3@krue.ml',
    'version' => '3.0.0-dev',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.11-11.5.99',
            'fluid_styled_content' => '10.4.11-11.5.99',
        ],
        'suggests' => [
            't3editor' => '',
        ],
    ],
    'autoload' => [
        'psr-4' => ['Brotkrueml\\CodeHighlight\\' => 'Classes']
    ],
];
