<?php
    $appDir = dirname(dirname(__FILE__));
    spl_autoload_register(function ($className) use ($appDir) {
        include  $appDir . '/src/' . $className . '.php';
    });

    if (empty($_POST) && empty($_GET)) {
        $sites = Site::getSites();
        $content = include $appDir . '/src/View/home.php';
        include $appDir . '/src/View/layout.php';
    } else {
        $deploy = new Deploy();
        if (empty($_POST)) {
            $content =
                '<strong>' . $deploy->triggerMsg . '</strong>' .
                '<pre>' . $deploy->screenOutput->content . '</pre>';
            include $appDir . '/src/View/layout.php';
        } else {
            echo $deploy->triggerMsg . "\n" . $deploy->screenOutput->content;
        }
    }
