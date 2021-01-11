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

return [
    'commentaries-cake3' => [
        'master' => [
            'dir' => 'commentaries',
            'url' => 'https://cake3.commentaries.cberdata.org'
        ]
    ],
    'community-asset-inventory-cakephp3' => [
        'development' => [
            'dir' => 'cair_staging',
            'url' => 'https://staging.cair.cberdata.org'
        ],
        'master' => [
            'dir' => 'cair',
            'url' => 'https://cair.cberdata.org'
        ]
    ],
    'datacenter-home' => [
        'development' => [
            'dir' => 'data_center_home_staging',
            'url' => 'https://staging.home.cberdata.org'
        ],
        'master' => [
            'dir' => 'data_center_home',
            'url' => 'https://cberdata.org'
        ]
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
    ],
    'school-rankings' => [
        'master' => [
            'dir' => 'school',
            'url' => 'https://school.cberdata.org'
        ]
    ],
    'vore-arts-fund' => [
        'development' => [
            'dir' => 'vore_staging',
            'url' => 'https://staging.voreartsfund.org'
        ],
        'master' => [
            'dir' => 'vore',
            'url' => 'https://voreartsfund.org'
        ]
    ],
    'whyarewehere' => [
        'development' => [
            'dir' => 'student_work_staging',
            'url' => 'https://staging.studentwork.cberdata.org'
        ],
        'master' => [
            'dir' => 'student_work',
            'url' => 'https://studentwork.cberdata.org'
        ]
    ]
];
