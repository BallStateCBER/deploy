<?php
class Log
{
    public $content = '';

    public function __construct()
    {
        $this->addLine("####### " . date('Y-m-d H:i:s') . " #######\n");
    }

    public function addLine($line)
    {
        $this->content .= $line . "\n";
    }

    public function write()
    {
        $siteName = Request::getSiteName();
        $filename = dirname(dirname(__FILE__)) . "/logs/$siteName.log";
        file_put_contents ($filename, $this->content, FILE_APPEND);
    }
}
