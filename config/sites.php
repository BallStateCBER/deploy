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
    'tax-calculator' => [
        'development' => 'tax_calculator_staging',
        'master' => 'tax_calculator'
    ]
];
