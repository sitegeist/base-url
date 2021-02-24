<?php
$EM_CONF['base_url'] = [
    'title' => 'Base URL',
    'description' => 'Determinates base URL from site configurations for scripts where no FE or BE context is avilable like commands or tasks',
    'category' => 'fe',
    'author' => 'Ulrich Mathes',
    'author_email' => 'mathes@sitegeist.de',
    'author_company' => 'sitegeist media solutions GmbH',
    'state' => 'stable',
    'uploadfolder' => false,
    'clearCacheOnLoad' => false,
    'version' => '1.1.4',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.9.9',
            'php' => '7.2.0-7.9.99'
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Sitegeist\\BaseUrl\\' => 'Classes'
        ]
    ],
];
