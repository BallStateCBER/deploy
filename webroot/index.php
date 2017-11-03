<?php
    spl_autoload_register(function ($className) {
        include dirname(dirname(__FILE__)) . '/src/' . $className . '.php';
    });
    $deploy = new Deploy();

    if (empty($_POST)) {
        $content =
            '<strong>' . $deploy->triggerMsg . '</strong>' .
            '<pre>' . $deploy->screenOutput->content . '</pre>';
        include dirname(dirname(__FILE__)) . '/src/View/layout.php';
    } else {
        echo $deploy->triggerMsg . "\n" . $deploy->screenOutput->content;
    }
