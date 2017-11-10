<?php
namespace App;

class Site
{
    /**
     * Returns whether or not $siteName is listed in sites.php
     *
     * @param string $siteName Name of GitHub repository
     * @return bool
     */
    public static function isValid($siteName)
    {
        $sites = include dirname(dirname(__FILE__)) . '/config/sites.php';

        return isset($sites[$siteName]);
    }

    /**
     * Returns the array of information stored in /config/sites.php about the specified site
     *
     * @param string $siteName Name of GitHub repository
     * @return array
     */
    public static function getSite($siteName)
    {
        $sites = self::getSites();

        return $sites[$siteName];
    }

    /**
     * Returns the array stored in /config/sites.php
     *
     * @return array
     */
    public static function getSites()
    {
        return include dirname(dirname(__FILE__)) . '/config/sites.php';
    }

    /**
     * Returns whether or not the specified branch is recognized for the specified site
     *
     * @param string $branch Branch name
     * @param array $site Array of information about a site
     * @return bool
     */
    public static function isValidBranch($branch, $site)
    {
        $availableBranches = Site::getAvailableBranches($site);

        return in_array($branch, $availableBranches);
    }

    /**
     * Returns the branches associated with a site in /config/sites.php
     *
     * @param array $site Array of information about a site
     * @return array
     */
    public static function getAvailableBranches($site)
    {
        return array_keys($site);
    }
}
