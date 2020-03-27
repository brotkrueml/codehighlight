<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Code Highlight',
    'description' => 'Code highlighter for various programming languages',
    'category' => 'fe',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'author' => 'Chris Müller',
    'author_email' => 'typo3@krue.ml',
    'version' => '2.1.0-dev',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.5-10.4.99',
            'fluid_styled_content' => '9.5.5-10.4.99',
        ],
        'suggests' => [
            't3editor' => '9.5.5-10.4.99',
        ],
    ],
    'autoload' => [
        'psr-4' => ['Brotkrueml\\CodeHighlight\\' => 'Classes']
    ],
];
