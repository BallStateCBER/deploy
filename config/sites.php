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

$cake3CacheClear = 'php bin/cake.php orm_cache clear';
$cake4CacheClear = 'php bin/cake.php schema_cache build --connection default';
$migrate = 'php bin/cake.php migrations migrate';

return [
    'commentaries-cake3' => [
        'master' => [
            'dir' => 'commentaries',
            'url' => 'https://cake3.commentaries.cberdata.org',
            'php' => 7,
        ],
        'commands' => [$cake3CacheClear, $migrate],
    ],
    'community-asset-inventory-cakephp3' => [
        'development' => [
            'dir' => 'cair_staging',
            'url' => 'https://staging.cair.cberdata.org',
            'php' => 7,
        ],
        'master' => [
            'dir' => 'cair',
            'url' => 'https://cair.cberdata.org',
            'php' => 7,
        ],
        'commands' => [$cake3CacheClear, $migrate],
    ],
    'datacenter-home' => [
        'master' => [
            'dir' => 'data_center_home',
            'url' => 'https://cberdata.org'
        ],
        'commands' => [$cake4CacheClear],
    ],
    'deploy' => [
        'master' => [
            'dir' => 'deploy',
            'url' => 'https://deploy.cberdata.org',
            'php' => 7,
        ]
    ],
    'economic-indicators-cakephp4' => [
        'master' => [
            'dir' => 'indicators',
            'url' => 'https://indicators.cberdata.org',
        ],
        'development' => [
            'dir' => 'indicators_staging',
            'url' => 'https://staging.indicators.cberdata.org',
        ],
        'commands' => [$cake4CacheClear, $migrate],
    ],
    'projects-cakephp4' => [
        'development' => [
            'dir' => 'projects_staging',
            'url' => 'https://staging.projects.cberdata.org',
        ],
        'master' => [
            'dir' => 'projects',
            'url' => 'https://projects.cberdata.org',
        ],
        'commands' => [$cake4CacheClear, $migrate],
    ],
    'school-rankings' => [
        'master' => [
            'dir' => 'school',
            'url' => 'https://school.cberdata.org',
            'php' => 7,
        ],
        'commands' => [$cake3CacheClear, $migrate],
    ],
    'whyarewehere' => [
        'development' => [
            'dir' => 'student_work_staging',
            'url' => 'https://staging.studentwork.cberdata.org',
            'php' => 7,
        ],
        'master' => [
            'dir' => 'student_work',
            'url' => 'https://studentwork.cberdata.org',
            'php' => 7,
        ],
        'commands' => [$cake3CacheClear, $migrate],
    ]
];
