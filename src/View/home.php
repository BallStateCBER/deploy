<?php ob_start(); ?>

<table class="table"><tr><th>Repo</th><th>Branches</th></tr>
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
        </tr>
    <?php endforeach; ?>
</table>

<?php
    return ob_get_clean();