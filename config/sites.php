<?php
/**
 * A list of sites that are eligible for automatic deployment,
 * with the names of the subdirectories of public_html that correspond to each auto-deployable branch.
 */

return [
    'commentaries_cake3' => [
        'master' => [
            'dir' => 'commentaries',
            'url' => 'https://cake3.commentaries.cberdata.org'
        ]
    ],
    'cri' => [
        'development' => [
            'dir' => 'cri_staging',
            'url' => 'https://staging.cri.cberdata.org'
        ],
        'master' => [
            'dir' => 'cri',
            'url' => 'https://cri.cberdata.org'
        ]
    ],
    'datacenter_home' => [
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
    'muncie_events' => [
        'development' => [
            'dir' => 'muncie_events_staging',
            'url' => 'https://staging.muncieevents.com'
        ],
        'master' => [
            'dir' => 'muncie_events',
            'url' => 'https://muncieevents.com'
        ]
    ],
    'muncie_events3' => [
        'development' => [
            'dir' => 'muncie_events_cakephp3_staging',
            'url' => 'https://staging.cake3.muncieevents.com'
        ],
        'master' => [
            'dir' => 'muncie_events_cakephp3',
            'url' => 'https://cake3.muncieevents.com'
        ]
    ],
    'muncie-events-api' => [
        'development' => [
            'dir' => 'muncie_events_api_staging',
            'url' => 'https://staging.api.muncieevents.com'
        ],
        'master' => [
            'dir' => 'muncie_events_api',
            'url' => 'https://api.muncieevents.com'
        ]
    ],
    'projects-cakephp3' => [
        'development' => [
            'dir' => 'projects_staging',
            'url' => 'https://staging.projects3.cberdata.org'
        ],
        'master' => [
            'dir' => 'projects',
            'url' => 'https://projects.cberdata.org'
        ]
    ],
    'tax-calculator' => [
        'development' => [
            'dir' => 'tax_calculator_staging',
            'url' => 'https://staging.tax-comparison.cberdata.org'
        ],
        'master' => [
            'dir' => 'tax_calculator',
            'url' => 'https://tax-comparison.cberdata.org'
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
