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
                $line = $this->removeDownloading($line);
                $this->addLine($prefix . trim($line));
            }
        }
    }

    /**
     * Removes the repetitive "Downloading (0%)Downloading (10%)Downloading (20%)..." strings from $msg
     *
     * @param string $msg Message
     * @return string
     */
    public function removeDownloading($msg)
    {
        while (stripos($msg, 'Downloading') !== false && stripos($msg, ')') !== false) {
            $start = stripos($msg, 'Downloading');
            $end = stripos($msg, ')');
            $substr = substr($msg, $start, $end - $start);
            $msg = str_replace($substr, '', $msg);
        }

        return $msg;
    }
}
