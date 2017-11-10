<?php
    $appDir = dirname(dirname(__FILE__));
    spl_autoload_register(function ($className) use ($appDir) {
        $className = str_replace('App\\', '', $className);
        include  $appDir . '/src/' . $className . '.php';
    });

    if (empty($_POST) && empty($_GET)) {
        $sites = App\Site::getSites();
        $content = include $appDir . '/src/View/home.php.template';
        include $appDir . '/src/View/layout.php.template';
    } else {
        $deploy = new App\Deploy();
        if (empty($_POST)) {
            $content =
                '<strong>' . $deploy->triggerMsg . '</strong>' .
                '<pre>' . $deploy->screenOutput->content . '</pre>';
            include $appDir . '/src/View/layout.php.template';
        } else {
            echo $deploy->triggerMsg . "\n" . $deploy->screenOutput->content;
        }
    }
