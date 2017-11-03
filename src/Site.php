<?php
class Site
{
    public static function isValid($siteName)
    {
        $sites = include dirname(dirname(__FILE__)) . '/config/sites.php';

        return isset($sites[$siteName]);
    }

    public static function getSite($siteName)
    {
        $sites = self::getSites();

        return $sites[$siteName];
    }

    public static function getSites()
    {
        return include dirname(dirname(__FILE__)) . '/config/sites.php';
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
