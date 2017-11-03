<?php
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
    return $content;