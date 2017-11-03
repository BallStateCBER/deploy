<?php
class Log
{
    public $content = '';
    public $entryId;

    public function __construct()
    {
        $this->entryId = date('YmdHis');
        $this->content .= '<h1 id="' . $this->entryId . '">####### ' . date('Y-m-d H:i:s') . " #######</h1>\n";
    }

    public function addLine($line)
    {
        $this->content .= nl2br($line) . "<br />\n";
    }

    public function write()
    {
        $this->content .= '<hr />';
        $siteName = Request::getSiteName();
        $filename = dirname(dirname(__FILE__)) . "/logs/$siteName.html";
        file_put_contents ($filename, $this->content, FILE_APPEND);
    }
}
