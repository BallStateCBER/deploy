<?php
namespace App;

/**
 * Class Dependency
 *
 * Class for handling the updating of a dependency, such as ballstatecber/datacenter-plugin-cakephp3
 *
 * @package App
 */
class Dependency
{
    /**
     * Halts execution if this branch shouldn't trigger site updates
     *
     * @param string $branch Branch name
     */
    public static function validateBranch($branch)
    {
        if ($branch !== 'master') {
            echo "$branch branch doesn't trigger site updates.";
            exit;
        }
    }

    /**
     * Opens the site directory with the specified name
     *
     * @param string $directory Directory name, relative to sites root
     * @return void
     */
    public static function openSiteDir($directory)
    {
        $siteDir = self::getFullSiteDir($directory);
        if (!file_exists($siteDir)) {
            echo "$siteDir not found";
            exit;
        }

        chdir($siteDir);
    }

    /**
     * Returns the full path to the specified site directory
     *
     * @param string $directory Directory name, relative to sites root
     * @return string
     */
    public static function getFullSiteDir($directory)
    {
        $sitesRoot = dirname(dirname(dirname(__FILE__)));

        return $sitesRoot . '/' . $directory;
    }
}
