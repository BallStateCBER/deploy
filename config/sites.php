<?php
/**
 * A list of sites that are eligible for automatic deployment,
 * with the names of the subdirectories of public_html that correspond to each auto-deployable branch.
 */

return [
    'tax-calculator' => [
        'development' => 'tax_calculator_cloned',
        'master' => 'tax_calculator'
    ]
];
