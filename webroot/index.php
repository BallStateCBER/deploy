<?php
    spl_autoload_register(function ($className) {
        include dirname(dirname(__FILE__)) . '/src/' . $className . '.php';
    });

    if (empty($_POST) && empty($_GET)) {
        $sites = Site::getSites();
        $content = '<ul>';
        foreach ($sites as $site => $branches) {
            $content .= '<li>' . $site . ': ';
            $links = [];
            foreach ($branches as $branch => $dir) {
                $links[] = '<a href="/' . $site . '/' . $branch . '">' . $branch . '</a>';
            }
            $content .= implode(', ', $links) . '</li>';
        }
        $content .= '</ul>';
        include dirname(dirname(__FILE__)) . '/src/View/layout.php';
    } else {
        $deploy = new Deploy();
        if (empty($_POST)) {
            $content =
                '<strong>' . $deploy->triggerMsg . '</strong>' .
                '<pre>' . $deploy->screenOutput->content . '</pre>';
            include dirname(dirname(__FILE__)) . '/src/View/layout.php';
        } else {
            echo $deploy->triggerMsg . "\n" . $deploy->screenOutput->content;
        }
    }
