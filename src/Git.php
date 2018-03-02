<?php
namespace App;

class Git
{
    /**
     * @param $siteName
     * @param $branch
     * @throws \Exception
     * @return bool
     */
    public static function canPull($siteName, $branch)
    {
        if (!Site::isValid($siteName)) {
            throw new \Exception('Unrecognized site name: ' . $siteName);
        }

        $site = Site::getSite($siteName);
        if (!Site::isValidBranch($branch, $site)) {
            throw new \Exception("$branch branch does not exist for $siteName repo");
        }

        // Make sure site directory exists
        $appDir = dirname(dirname(__FILE__));
        $sitesRoot = dirname($appDir);
        $siteDir = $sitesRoot . '/' . $site[$branch]['dir'];
        if (!file_exists($siteDir)) {
            return false;
        }

        $sitesRoot = dirname($appDir);
        $siteDir = $sitesRoot . '/' . $site[$branch]['dir'];

        // Change working directory to appropriate website
        chdir($siteDir);

        // Check to see if status mentions modified files
        $results = shell_exec('git status');

        return !stripos($results, 'modified: ');
    }
}
