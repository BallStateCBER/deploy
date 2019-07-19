<?php
/**
 * Information about packages that are used as dependencies of various production sites. When the master branches of
 * these packages are updated, those sites should update their copies.
 *
 * Format:
 * [
 *      'repo-name' => [
 *          'package' => '...',  (e.g. ballstatecber/datacenter-plugin-cakephp3)
*           'directories' => ['...', ...] (e.g. cair, cair_staging, commentaries, etc.)
 *      ]
 * ]
 */

return [
    'datacenter-plugin-cakephp3' => [
        'package' => 'ballstatecber/datacenter-plugin-cakephp3',
        'directories' => [
            'cair',
            'cair_staging',
            'commentaries',
            'cri',
            'cri_staging',
            'data_center_home',
            'data_center_home_staging',
            'projects',
            'projects_staging',
            'tax_calculator',
            'tax_calculator_staging'
        ]
    ]
];
