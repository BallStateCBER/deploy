<?php ob_start(); ?>

<table class="table">
    <thead>
        <tr>
            <th>Repo</th>
            <th>Branches</th>
            <th>Logs</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sites as $site => $branches): ?>
            <tr>
                <td>
                    <?= $site ?>
                </td>
                <td>
                    <?php foreach ($branches as $branch => $dir): ?>
                        <a href="/<?= $site ?>/<?= $branch ?>">
                            <?= $branch ?>
                        </a>
                    <?php endforeach; ?>
                </td>
                <td>
                    <a href="log.php?site=<?= $site ?>">
                        View
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
    return ob_get_clean();