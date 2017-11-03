<?php
class Deploy
{
    public $triggerMsg;
    public $screenOutput;

    public function __construct()
    {
        $appDir = dirname(dirname(__FILE__));

        // Forbid unknown IP addresses
        if (!Request::isAuthorized()) {
            header('HTTP/1.1 403 Forbidden');
            echo 'Sorry, your IP address (' . Request::getIpAddress() . ') isn\'t authorized. 🙁';
            exit;
        }

        // Retrieve and validate site
        $siteName = Request::getSiteName();
        if (!$siteName) {
            header('HTTP/1.1 404 Not Found');
            echo 'No valid site name provided';
            exit;
        }
        if (!Site::isValid($siteName)) {
            header('HTTP/1.1 404 Not Found');
            echo 'Unrecognized site name: ' . $siteName;
            exit;
        }
        $site = Site::getSite($siteName);

        // Handle GitHub pings
        if (Request::isGithubPing()) {
            echo 'Ping received!';
            exit;
        }

        // Determine and validate branch
        $branch = Request::getBranch();
        if (!Site::isValidBranch($branch, $site)) {
            echo "$branch branch can't be auto-deployed. ";
            echo "Branches that can be auto-deployed: " . implode(', ', Site::getAvailableBranches($site));
            exit;
        }

        // Create a message explaining what triggered this deploy
        $this->triggerMsg = Request::getDeployTrigger();

        // Initialize various output
        $log = new Log();
        $log->addLine($this->triggerMsg);
        $this->screenOutput = new ScreenOutput();
        $slack = new Slack();
        $slack->addLine('*' . $this->triggerMsg . '*');

        // Make sure site directory exists
        $sitesRoot = dirname($appDir);
        $siteDir = $sitesRoot . '/' . $site[$branch];
        if (!file_exists($siteDir)) {
            echo "$siteDir not found";
            exit;
        }

        // Change working directory to appropriate website
        chdir($siteDir);

        // Run commands
        $commands = include $appDir . '/config/commands.php';
        foreach ($commands as $command) {
            $results = shell_exec("$command 2>&1");

            $log->addLine("\$ $command");
            $log->addLine(trim($results));

            $this->screenOutput->add('$ ', '#6BE234');
            $this->screenOutput->add($command . "\n", '#729FCF');
            $this->screenOutput->add(htmlentities(trim($results)) . "\n\n");

            // Format Slack message with command results in blockquote
            $slack->addLine("*\$ $command*");
            $slack->addLine(str_replace("\n", "\n>", "\n" . trim($results)));
        }

        // Write to log
        $log->addLine('');
        $log->write();

        // Send a message to Slack
        if (true || $slack->send()) {
            $this->screenOutput->add("Sent message to Slack");
        } else {
            $this->screenOutput->add('Error sending message to Slack: ');
            $this->screenOutput->add($slack->curlResult, 'red');
        }
    }
}