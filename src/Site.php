<?php
class Site
{
    public static function isValid($siteName)
    {
        $sites = include('../config/sites.php');

        return isset($sites[$siteName]);
    }

    public static function getSite($siteName)
    {
        $sites = include('../config/sites.php');

        return $sites[$siteName];
    }

    public static function isValidBranch($branch, $site)
    {
        $availableBranches = Site::getAvailableBranches($site);

        return in_array($branch, $availableBranches);
    }

    public static function getAvailableBranches($site)
    {
        return array_keys($site);
    }
}
