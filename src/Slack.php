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
        $url = include('../config/slack_webhook_url.php');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $this->curlResult = curl_exec($ch);
        curl_close($ch);

        return $this->curlResult == 'ok';
    }
}
