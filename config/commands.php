<?php
/**
 * A list of all commands to run via shell_exec() for each deployment
 */

return [
    'git pull',
    'git status',
    'php composer.phar self-update',
    'php composer.phar install'
];
