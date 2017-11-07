<?php
class Slack
{
    public $content;
    public $curlResult;

    public function addLine($line)
    {
        $this->content .= $line . "\n";
    }

    public function encodeContent()
    {
        $this->content = str_replace(
            ['&', '<', '>'],
            [
                urlencode('&amp;'),
                urlencode('&lt;'),
                urlencode('&gt;')
            ],
            $this->content
        );
    }

    public function send()
    {
        $this->encodeContent();
        $data = 'payload=' . json_encode([
            'channel' => '#server',
            'text' => $this->content,
            'icon_emoji' => ':robot_face:',
            'username' => 'CBER Deploy-bot'
        ]);
        $url = include dirname(dirname(__FILE__)) . '/config/slack_webhook_url.php';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $this->curlResult = curl_exec($ch);
        curl_close($ch);

        return $this->curlResult == 'ok';
    }

    public function addAbridged($command, $results)
    {
        if ($command == 'git pull') {
            $keyStrings = [
                'Already up-to-date',
                'error',
                'changed'
            ];
            foreach ($keyStrings as $keyString) {
                $this->addLinesWithString($results, $keyString, 'Git: ');
            }

            return;
        }

        if (strpos($command, 'composer.phar install') !== false) {
            $keyStrings = [
                'Nothing to install or update',
                'Updating'
            ];
            foreach ($keyStrings as $keyString) {
                $this->addLinesWithString($results, $keyString, 'Composer: ');
            }
        }
    }

    /**
     * Adds any lines in $message that include $search
     *
     * @param string $message Full, multi-line message
     * @param string $search Search term
     * @param string $prefix Optional prefix for added line
     * @return void
     */
    public function addLinesWithString($message, $search, $prefix = '')
    {
        if (strpos($message, $search) === false) {
            return;
        }

        foreach (explode("\n", $message) as $line) {
            if (stripos($line, $search) !== false) {
                $line = $this->trimDetails($line);
                $this->addLine($prefix . trim($line));
            }
        }
    }

    /**
     * Removes unnecessary details from Composer output messages
     *
     * @param string $msg Message
     * @return string
     */
    public function trimDetails($msg)
    {
        // Remove leading "- "
        if (substr($msg, 0, 2) == '- ') {
            $msg = substr($msg, 2);
        }

        // Remove "(Downloading X%)"
        while (stripos($msg, 'Downloading') !== false) {
            $start = stripos($msg, 'Downloading');
            $end = stripos($msg, ')', $start);
            if ($end === false) {
                break;
            }
            $substr = substr($msg, $start, $end - $start);
            $msg = str_replace($substr, '', $msg);
        }

        // Remove "Checking out..."
        $checkingOut = strpos($msg, ': Checking out');
        if ($checkingOut !== false) {
            $msg = substr($msg, 0, $checkingOut);
        }

        // Remove other strings
        $removeStrings = [
            ': Loading from cache'
        ];
        foreach ($removeStrings as $removeString) {
            $msg = str_replace($removeString, '', $msg);
        }

        $msg = trim($msg);

        return $msg;
    }
}
