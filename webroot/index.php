<?php
    $title = '🤖 CBER Deploy-bot 🤖';
    spl_autoload_register(function ($className) {
        include dirname(dirname(__FILE__)) . '/src/' . $className . '.php';
    });
    $deploy = new Deploy();
?>
<?php if (empty($_POST)): ?>
    <!DOCTYPE HTML>
    <html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <title>
            <?= $title ?>
        </title>
    </head>
    <body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
        <h1>
            <?= $title ?>
        </h1>
        <strong>
            <?= $deploy->triggerMsg ?>
        </strong>
        <pre>
            <?= $deploy->screenOutput->content ?>
        </pre>
    </body>
    </html>
<?php else: ?>
    <?= $deploy->triggerMsg . "\n" . $deploy->screenOutput->content ?>
<?php endif; ?>
