<?php $title = '🤖 CBER Deploy-bot 🤖'; ?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>
        <?= $title ?>
    </title>
    <style>
        body {
            background-color: #000000;
            color: #FFFFFF;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 18px;
            font-weight: bold;
            padding: 0 10px;
        }
        a {
            color: #3e97df;
            text-decoration: none;
        }
        a:hover,
        a:focus {
            color: #327eb8;
            text-decoration: underline;
        }
        h1 a {
            color: #fff;
        }
        h1 a:hover {
            color: #fff;
            text-decoration: none;
        }
        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tfoot > tr > th,
        .table > thead > tr > td,
        .table > tbody > tr > td,
        .table > tfoot > tr > td {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }
        .table > thead > tr > th {
            vertical-align: bottom;
            border-bottom: 2px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>
        <a href="/">
            <?= $title ?>
        </a>
    </h1>
    <?= $content ?>
</body>
</html>