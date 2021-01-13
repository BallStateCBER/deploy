<?php
/**
 * Information about sites that are eligible for automatic deployment
 *
 * Format:
 * [
 *      'repo-name' => [
 *          'branch-name' => [
 *              'dir' => 'corresponding subdirectory of public_html'
 *              'url' => 'URL for corresponding production/staging site'
 *          ],
 *          ...
 *          'commands' => [
 *              'command', // e.g. 'gulp less'
 *              ...
 *          ]
 *      ]
 * ]
 */

$cake3CacheClear = 'bin/cake orm_cache clear';
$cake4CacheClear = 'bin/cake schema_cache build --connection default';

return [
    'commentaries-cake3' => [
        'master' => [
            'dir' => 'commentaries',
            'url' => 'https://cake3.commentaries.cberdata.org'
        ],
        'commands' => [$cake3CacheClear],
    ],
    'community-asset-inventory-cakephp3' => [
        'development' => [
            'dir' => 'cair_staging',
            'url' => 'https://staging.cair.cberdata.org'
        ],
        'master' => [
            'dir' => 'cair',
            'url' => 'https://cair.cberdata.org'
        ],
        'commands' => [$cake3CacheClear],
    ],
    'datacenter-home' => [
        'development' => [
            'dir' => 'data_center_home_staging',
            'url' => 'https://staging.home.cberdata.org'
        ],
        'master' => [
            'dir' => 'data_center_home',
            'url' => 'https://cberdata.org'
        ],
        'commands' => [$cake4CacheClear],
    ],
    'deploy' => [
        'master' => [
            'dir' => 'deploy',
            'url' => 'https://deploy.cberdata.org'
        ]
    ],
    'economic-indicators-cakephp4' => [
        'master' => [
            'dir' => 'indicators',
            'url' => 'https://indicators4.cberdata.org',
        ],
        'commands' => [$cake4CacheClear],
    ],
    'muncie-events-api' => [
        'development' => [
            'dir' => 'muncie_events_staging',
            'url' => 'https://staging.muncieevents.com',
        ],
        'master' => [
            'dir' => 'muncie_events',
            'url' => 'https://muncieevents.com',
        ],
        'commands' => [$cake3CacheClear],
    ],
    'school-rankings' => [
        'master' => [
            'dir' => 'school',
            'url' => 'https://school.cberdata.org'
        ],
        'commands' => [$cake3CacheClear],
    ],
    'vore-arts-fund' => [
        'development' => [
            'dir' => 'vore_staging',
            'url' => 'https://staging.voreartsfund.org'
        ],
        'master' => [
            'dir' => 'vore',
            'url' => 'https://voreartsfund.org'
        ],
        'commands' => [$cake4CacheClear],
    ],
    'whyarewehere' => [
        'development' => [
            'dir' => 'student_work_staging',
            'url' => 'https://staging.studentwork.cberdata.org'
        ],
        'master' => [
            'dir' => 'student_work',
            'url' => 'https://studentwork.cberdata.org'
        ],
        'commands' => [$cake3CacheClear],
    ]
];
