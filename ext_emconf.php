<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Code Highlight',
    'description' => 'Code highlighter for various languages',
    'category' => 'fe',
    'state' => 'alpha',
    'clearCacheOnLoad' => 1,
    'author' => 'Chris Müller',
    'author_email' => 'typo3@krue.ml',
    'version' => '0.1.0-dev',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.5-10.0.99',
        ],
        'suggests' => [
            't3editor' => '9.5.5-10.0.99',
        ],
    ],
    'autoload' => [
        'psr-4' => ['Brotkrueml\\CodeHighlight\\' => 'Classes']
    ],
];
