<?php
namespace App;

use Exception;

class Deploy
{
    public $triggerMsg;
    public $screenOutput;

    /**
     * Deploy constructor
     */
    public function __construct()
    {
        $appDir = dirname(dirname(__FILE__));

        // Forbid unknown IP addresses
        if (!Request::isAuthorized()) {
            try {
                if (!Request::isGitHub()) {
                    header('HTTP/1.1 403 Forbidden');
                    echo 'Sorry, your IP address (' . Request::getIpAddress() . ') isn\'t authorized. 🙁';
                    exit;
                }
            } catch (Exception $e) {
                header('HTTP/1.1 500 Internal Server Error');
                echo $e->getMessage();
                exit;
            }
        }

        // Handle GitHub pings
        if (Request::isGithubPing()) {
            echo 'Ping received!';
            exit;
        }

        // Retrieve and validate site
        $repoName = Request::getRepoName();
        if (!$repoName) {
            header('HTTP/1.1 404 Not Found');
            echo 'No valid repo name provided';
            exit;
        }
        if (!Site::isValid($repoName)) {
            header('HTTP/1.1 404 Not Found');
            echo 'Unrecognized repo name: ' . $repoName;
            exit;
        }
        $site = Site::getSite($repoName);

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
        $log->addLine('');
        $this->screenOutput = new ScreenOutput();
        $slack = new Slack();
        $slack->addTriggerMsg($this->triggerMsg);

        // Make sure site directory exists
        $sitesRoot = dirname($appDir);
        $siteDir = $sitesRoot . '/' . $site[$branch]['dir'];
        if (!file_exists($siteDir)) {
            echo "$siteDir not found";
            exit;
        }

        // Change working directory to appropriate website
        chdir($siteDir);

        // Run commands
        $commands = include $appDir . '/config/commands.php';
        if (isset($site['commands'])) {
            $commands = array_merge($commands, $site['commands']);
        }
        foreach ($commands as $command) {
            $results = shell_exec("$command 2>&1");

            $log->addLine("<strong>\$ $command</strong>");
            $log->addLine(trim($results));
            $log->addLine('');

            $this->screenOutput->add('$ ', '#6BE234');
            $this->screenOutput->add($command . "\n", '#729FCF');
            $this->screenOutput->add(htmlentities(trim($results)) . "\n\n");

            $slack->addAbridged($command, $results);
        }
        $logUrl = 'http://deploy.cberdata.org/log.php?site=' . $repoName . '#' . $log->entryId;
        $slack->addLine('*Log:* ' . $logUrl);

        // Display link to view updated site
        if (isset($site[$branch]['url'])) {
            $slack->addLine('*Load updated site:* ' . $site[$branch]['url']);
        }

        // Write to log
        $log->addLine('');
        $log->write();

        // Send a message to Slack
        if ($slack->send()) {
            $this->screenOutput->add("Sent message to Slack");
        } else {
            $this->screenOutput->add('Error sending message to Slack: ');
            $this->screenOutput->add($slack->curlResult, 'red');
        }
    }
}
