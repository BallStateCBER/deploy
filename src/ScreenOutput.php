<?php
class ScreenOutput
{
    public $content;

    public function __construct()
    {
        $this->content .= "\n";
    }

    public function add($content, $color = null)
    {
        if ($color) {
            $this->content .= '<span style="color: ' . $color . ';">' . $content . '</span>';
        } else {
            $this->content .= $content;
        }
    }
}
