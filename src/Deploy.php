<?php
namespace App;

use Exception;

/**
 * Class Deploy
 *
 * @package App
 * @property array $site
 * @property Log $log
 * @property ScreenOutput $screenOutput
 * @property Slack $slack
 * @property string $branch
 * @property string $repoName
 */
class Deploy
{
    public $branch;
    public $log;
    public $repoName;
    public $screenOutput;
    public $site;
    public $slack;

    /**
     * Deploy constructor
     */
    public function __construct()
    {
        $this->validateIpAddress();
        $this->handleGithubPings();

        $this->repoName = $this->getRepoName();
        $this->branch = Request::getBranch();

        $this->site = Site::getSite($this->repoName);
        $this->validateBranch();

        $this->initializeLogging();
        $this->setEnvVars();
        $this->runCommands();
        $this->finishLogging();
    }

    /**
     * Forbids unknown IP addresses
     *
     * @return void
     */
    private function validateIpAddress()
    {
        if (Request::isAuthorized()) {
            return;
        }

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

    /**
     * Replies and aborts execution if this request is a Github ping
     *
     * @return void
     */
    private function handleGithubPings()
    {
        if (Request::isGithubPing()) {
            echo 'Ping received!';
            exit;
        }
    }

    /**
     * Retrieves this request's valid repository name or throws an error if it's missing or invalid
     *
     * @return string
     */
    private function getRepoName()
    {
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

        return $repoName;
    }

    /**
     * Halts execution if the current branch can't be auto-deployed
     *
     * @return void
     */
    private function validateBranch()
    {
        if (!Site::isValidBranch($this->branch, $this->site)) {
            echo "$this->branch branch can't be auto-deployed. ";
            echo "Branches that can be auto-deployed: " . implode(', ', Site::getAvailableBranches($this->site));
            exit;
        }
    }

    /**
     * Changes the current working directory to the appropriate website
     *
     * @return void
     */
    private function openSiteDir()
    {
        $appDir = dirname(dirname(__FILE__));
        $sitesRoot = dirname($appDir);
        $siteDir = $sitesRoot . '/' . $this->site[$this->branch]['dir'];
        if (!file_exists($siteDir)) {
            echo "$siteDir not found";
            exit;
        }

        chdir($siteDir);
    }

    /**
     * Runs all of the commands for deploying an update
     *
     * @return void
     */
    private function runCommands()
    {
        $phpVersion = $this->getPhpVersion();
        $appDir = dirname(dirname(__FILE__));
        $this->openSiteDir();
        $commands = include $appDir . '/config/commands.php';
        if (isset($this->site['commands'])) {
            $commands = array_merge($commands, $this->site['commands']);
        }
        foreach ($commands as $command) {
            $command = $this->adaptCommandToPhpVersion($command, $phpVersion);
            $results = shell_exec("$command 2>&1");

            $this->log->addLine("<strong>\$ $command</strong>");
            $this->log->addLine(trim($results));
            $this->log->addLine('');

            $this->screenOutput->add('$ ', '#6BE234');
            $this->screenOutput->add($command . "\n", '#729FCF');
            $this->screenOutput->add(htmlentities(trim($results)) . "\n\n");

            $this->slack->addAbridged($command, $results);
        }
        $logUrl = 'http://deploy.cberdata.org/log.php?site=' . $this->repoName . '#' . $this->log->entryId;
        $this->slack->addLine('*Log:* ' . $logUrl);
    }

    /**
     * Initializes output for the log, slack, and screen, and logs the trigger message
     *
     * @return void
     */
    private function initializeLogging()
    {
        $triggerMsg = Request::getDeployTrigger();

        $this->log = new Log();
        $this->log->addLine($triggerMsg);
        $this->log->addLine('');

        $this->screenOutput = new ScreenOutput();

        $this->slack = new Slack();
        $this->slack->addTriggerMsg($triggerMsg);
    }

    /**
     * Sends a message to Slack or outputs error information
     *
     * @return void
     */
    private function sendSlackOutput()
    {
        if ($this->slack->send()) {
            $this->screenOutput->add('Sent message to Slack');
        } else {
            $this->screenOutput->add('Error sending message to Slack: ');
            $this->screenOutput->add($this->slack->curlResult, 'red');
        }
    }

    /**
     * Adds a link to view the updated site to slack
     *
     * @return void
     */
    private function addSiteLinkToSlack()
    {
        if (isset($this->site[$this->branch]['url'])) {
            $this->slack->addLine('*Load updated site:* ' . $this->site[$this->branch]['url']);
        }
    }

    /**
     * Writes to the log and sends slack message
     *
     * @return void
     */
    private function finishLogging()
    {
        $this->log->addLine('');
        $this->log->write();

        $this->addSiteLinkToSlack();
        $this->sendSlackOutput();
    }

    /**
     * Handles a dependency being updated and sites that use it being updated, then halts execution
     *
     * @return void
     */
    private function handleDependencyUpdate()
    {
        $dependencies = include dirname(dirname(__FILE__)) . '/config/dependencies.php';

        if (!isset($dependencies[$this->repoName])) {
            return;
        }

        Dependency::validateBranch($this->branch);

        $dependency = $dependencies[$this->repoName];
        $packageName = $dependency['package'];
        $this->initializeLogging();
        foreach ($dependency['directories'] as $directory) {
            Dependency::openSiteDir($directory);

            $command = "composer update $packageName";
            $results = shell_exec("$command 2>&1");
            $siteDir = Dependency::getFullSiteDir($directory);

            $this->log->addLine("<strong>\$ cd $siteDir</strong>");
            $this->log->addLine("<strong>\$ $command</strong>");
            $this->log->addLine(trim($results));
            $this->log->addLine('');

            $this->screenOutput->add('$ ', '#6BE234');
            $this->screenOutput->add("cd $siteDir\n", '#729FCF');
            $this->screenOutput->add("$command\n", '#729FCF');
            $this->screenOutput->add(htmlentities(trim($results)) . "\n\n");

            $this->slack->addAbridged($command, $results);
        }

        $this->finishLogging();

        // Halt execution so this request isn't processed as a site repo getting updated
        exit;
    }

    /**
     * Sets environment variables
     *
     * @return void
     */
    private function setEnvVars()
    {
        putenv('COMPOSER_HOME=/home/okbvtfr/.composer');
    }

    /**
     * Returns the major PHP version associated with the current site/branch
     *
     * @return int
     */
    private function getPhpVersion(): int
    {
        if ($this->site[$this->branch]['php']) {
            return (int)$this->site[$this->branch]['php'];
        }

        return 8;
    }

    /**
     * Temporarily changes the path to PHP for this command, if required
     *
     * @param string $command Command
     * @param int $phpVersion PHP major version
     * @return string
     */
    private function adaptCommandToPhpVersion(string $command, int $phpVersion): string
    {
        if ($phpVersion == 7) {
            return 'env PATH="/opt/cpanel/ea-php74/root/usr/bin:$PATH" ' . $command;
        }

        return $command;
    }
}
