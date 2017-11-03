<?php
    if (isset($_GET['site'])) {
        $siteName = $_GET['site'];
        $path = dirname(dirname(__FILE__)) . '/logs/' . $siteName . '.html';
        if (file_exists($path)) {
            include $path;
        } else {
            echo 'Log file not found';
        }
    } else {
        echo 'No site name provided';
    }
