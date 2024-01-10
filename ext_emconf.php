<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Base URL',
    'description' => 'Determinates base URL from site configurations for scripts where no FE or BE context is available like commands or tasks',
    'category' => 'fe',
    'author' => 'Ulrich Mathes',
    'author_email' => 'mathes@sitegeist.de',
    'author_company' => 'sitegeist media solutions GmbH',
    'state' => 'stable',
    'uploadfolder' => false,
    'clearCacheOnLoad' => false,
    'version' => '1.1.6',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-12.9.9',
            'php' => '7.4.0-8.9.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'Sitegeist\\BaseUrl\\' => 'Classes'
        ]
    ],
];
