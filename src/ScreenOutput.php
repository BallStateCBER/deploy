<?php
class ScreenOutput
{
    public $content;

    public function __construct()
    {
        $this->content .= "\n";
    }

    /**
     * Appends text to $this->content and (if this isn't a POST request) styles it in the (optional) specified color
     *
     * @param $content
     * @param null $color
     */
    public function add($content, $color = null)
    {
        if ($color && empty($_POST)) {
            $this->content .= '<span style="color: ' . $color . ';">' . $content . '</span>';
        } else {
            $this->content .= $content;
        }
    }
}
