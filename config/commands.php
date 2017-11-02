<?php
/**
 * A list of all commands to run via shell_exec() for each deployment
 */

$composer = 'php /home/okbvtfr/public_html/deploy/composer.phar';

return [
    'git pull',
    'git status',
    "$composer self-update",
    "$composer install"
];
