<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Code Highlight',
    'description' => 'Code highlighter for various programming, markup and configuration languages',
    'category' => 'fe',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'author' => 'Chris Müller',
    'author_email' => 'typo3@krue.ml',
    'version' => '2.12.0-dev',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.16-11.5.99',
            'fluid_styled_content' => '9.5.16-11.5.99',
        ],
        'suggests' => [
            't3editor' => '9.5.16-11.5.99',
        ],
    ],
    'autoload' => [
        'psr-4' => ['Brotkrueml\\CodeHighlight\\' => 'Classes']
    ],
];
