<?php
$EM_CONF['base_url'] = [
    'title' => 'Base URL',
    'description' => '',
    'category' => 'fe',
    'author' => 'Ulrich Mathes',
    'author_email' => 'mathes@sitegeist.de',
    'author_company' => 'sitegeist media solutions GmbH',
    'state' => 'alpha',
    'uploadfolder' => false,
    'clearCacheOnLoad' => false,
    'version' => '0.0.1',
    'constraints' => [
        'depends' => [
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
