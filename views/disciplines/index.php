<?php

$isAdmin = app()->auth::user()->role === 'admin';

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
                <?php if($isAdmin): ?>
                    |
                    <a href="<?= app()->route->getUrl('/discipline/delete').'?id='.$d->id ?>"
                       onclick="return confirm('Удалить дисциплину?')">удалить</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>