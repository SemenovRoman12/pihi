<?php /** @var Discipline[] $disciplines */

use Model\Discipline; ?>
<h2>Дисциплины</h2>
<a href="<?= app()->route->getUrl('/discipline/create') ?>">Добавить</a>
<table>
    <tr><th>Название</th><th>Часы</th><th></th></tr>
    <?php foreach ($disciplines as $d): ?>
        <tr>
            <td><?= $d->name ?></td>
            <td><?= $d->hours ?></td>
            <td>
                <a href="<?= app()->route->getUrl('/discipline/edit').'?id='.$d->id ?>">редактировать</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
