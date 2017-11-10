<?php
class Request
{
    /**
     * Returns the IP address making the current request
     *
     * @return string
     */
    public static function getIpAddress()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Returns the name of the GitHub repository associated with the current request
     *
     * @return string|bool
     */
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

    /**
     * Returns whether or not the current request is a GitHub ping event
     *
     * @return bool
     */
    public static function isGithubPing()
    {
        return isset($_SERVER['HTTP_X_GITHUB_EVENT']) && $_SERVER['HTTP_X_GITHUB_EVENT'] == 'ping';
    }

    /**
     * Returns the name of the branch associated with the current request
     *
     * @return string|bool
     */
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

    /**
     * Returns a string describing what caused this deployment to happen
     *
     * @return string
     */
    public static function getDeployTrigger()
    {
        $branch = Request::getBranch();
        $siteName = Request::getSiteName();

        if (empty($_POST)) {
            $ip = Request::getIpAddress();
            $allowedIps = include dirname(dirname(__FILE__)) . '/config/allowed_ip_addresses.php';
            $requesterName = array_search($ip, $allowedIps);

            return "Deploy triggered manually by $requesterName for $branch branch of $siteName";
        }

        $payload = Request::getPayload();
        $pusher = $payload->pusher->name;
        $beforeSha = substr($payload->before, 0, 7);
        $afterSha = substr($payload->after, 0, 7);

        return "Push from $pusher updated head SHA of $branch branch of $siteName from $beforeSha to $afterSha";
    }

    /**
     * Returns the decoded payload sent by a GitHub webhook
     *
     * @return mixed|stdClass
     */
    public static function getPayload()
    {
        if (isset($_POST['payload'])) {
            return json_decode($_POST['payload']);
        }

        return new stdClass();
    }

    /**
     * Returns whether or not the current request was made by an IP address in allowed_ip_addresses.php
     *
     * @return bool
     */
    public static function isAuthorized()
    {
        $allowedIps = include dirname(dirname(__FILE__)) . '/config/allowed_ip_addresses.php';
        $ip = $_SERVER['REMOTE_ADDR'];
        foreach ($allowedIps as $name => $allowedIp) {
            if (strpos($ip, $allowedIp) === 0) {
                return true;
            }
        }

        return false;
    }
}
