<?php

$isAdmin = app()->auth::user()->role === 'admin';

use Model\Department; ?>
<h2>Кафедры</h2>
<a href="<?= app()->route->getUrl('/department/create') ?>">Добавить</a>
<table>
    <tr>
        <th>Название</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($departments as $d): ?>
        <tr>
            <td><?= $d->name ?></td>
            <td>
                <a href="<?= app()->route->getUrl('/department/edit') . '?id=' . $d->id ?>">редактировать</a>
                <?php if ($isAdmin): ?> |
                    <a href="<?= app()->route->getUrl('/department/delete') . '?id=' . $d->id ?>"
                       onclick="return confirm('Удалить кафедру?')">удалить</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

