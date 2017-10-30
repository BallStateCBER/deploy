<?php
class Request
{
    public static function getIpAddress()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public static function getSiteName()
    {
        if (isset($_POST['payload'])) {
            $payload = json_decode($_POST['payload']);
            if (isset($payload->repository->name)) {
                return $payload->repository->name;
            }

            return false;
        }

        if (isset($_GET['path'])) {
            return explode('/', $_GET['path'])[0];
        }

        return false;
    }

    public static function isGithubPing()
    {
        return isset($_SERVER['HTTP_X_GITHUB_EVENT']) && $_SERVER['HTTP_X_GITHUB_EVENT'] == 'ping';
    }

    public static function getBranch()
    {
        $siteName = Request::getSiteName();
        $site = Site::getSite($siteName);
        $availableBranches = array_keys($site);
        if (empty($_POST)) {
            if (strpos($_GET['path'], '/') === false) {
                header('HTTP/1.1 404 Not Found');
                echo 'No branch specified. Branches that can be auto-deployed: ' . implode(', ', $availableBranches);
                exit;
            }
            return explode('/', $_GET['path'])[1];
        } elseif (isset($_POST['payload'])) {
            $payload = json_decode($_POST['payload']);
            return explode('/', $payload->ref)[2];
        }

        return false;
    }

    public static function getDeployTrigger()
    {
        $branch = Request::getBranch();

        if (empty($_POST)) {
            $ip = Request::getIpAddress();
            $allowedIps = include('../config/allowed_ip_addresses.php');

            return 'Deploy triggered manually by ' . array_search($ip, $allowedIps) . " for $branch branch";
        }

        $payload = Request::getPayload();
        $pusher = $payload->pusher->name;
        $beforeSha = substr($payload->before, 0, 7);
        $afterSha = substr($payload->after, 0, 7);

        return "Push from $pusher updated head SHA of $branch branch from $beforeSha to $afterSha";
    }

    public static function getPayload()
    {
        if (isset($_POST['payload'])) {
            return json_decode($_POST['payload']);
        }

        return new stdClass();
    }

    public static function isAuthorized()
    {
        $allowedIps = include('../config/allowed_ip_addresses.php');
        $ip = $_SERVER['REMOTE_ADDR'];
        foreach ($allowedIps as $name => $allowedIp) {
            if (strpos($ip, $allowedIp) === 0) {
                return true;
            }
        }

        return false;
    }
}
