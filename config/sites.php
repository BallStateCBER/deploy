<?php
/**
 * A list of sites that are eligible for automatic deployment,
 * with the names of the subdirectories of public_html that correspond to each auto-deployable branch.
 */

return [
    'cri' => [
        'development' => 'cri_staging',
        'master' => 'cri'
    ],
    'datacenter_home' => [
        'development' => 'data_center_home_staging',
        'master' => 'data_center_home'
    ],
    'deploy' => [
        'master' => 'deploy'
    ],
    'muncie_events' => [
        'development' => 'muncie_events_staging',
        'master' => 'muncie_events'
    ],
    'muncie_events3' => [
        'development' => 'muncie_events_cakephp3_staging',
        'master' => 'muncie_events_cakephp3'
    ],
    'muncie-events-api' => [
        'development' => 'muncie_events_api_staging',
        'master' => 'muncie_events_api'
    ],
    'tax-calculator' => [
        'development' => 'tax_calculator_staging',
        'master' => 'tax_calculator'
    ],
    'whyarewehere' => [
        'development' => 'student_work_staging',
        'master' => 'student_work'
    ]
];
