<?php
/**
 * A list of sites that are eligible for automatic deployment,
 * with the names of the subdirectories of public_html that correspond to each auto-deployable branch.
 */

return [
    'datacenter_home' => [
        'development' => 'data_center_home_staging',
        'master' => 'data_center_home'
    ],
    'deploy' => [
        'master' => 'deploy'
    ],
    'muncie_events' => [
        'development' => 'muncie_events2_staging',
        'master' => 'muncie_events2'
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
