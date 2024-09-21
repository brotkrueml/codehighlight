<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Code Highlight',
    'description' => 'Code highlighter for various programming, markup and configuration languages based on PrismJS',
    'category' => 'fe',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'author' => 'Chris Müller',
    'author_email' => 'typo3@brotkrueml.dev',
    'version' => '4.1.1-dev',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
            'fluid_styled_content' => '12.4.0-13.4.99',
        ],
        'suggests' => [
            't3editor' => '',
        ],
    ],
    'autoload' => [
        'psr-4' => ['Brotkrueml\\CodeHighlight\\' => 'Classes']
    ],
];
