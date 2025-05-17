<?php

use Model\Department; ?>
<h2>Кафедры</h2>
<a href="<?= app()->route->getUrl('/department/create') ?>">Добавить</a>
<table>
    <thead>
    <tr>
        <th>Название</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($departments as $d): ?>
        <tr>
            <td><?= htmlspecialchars($d->name) ?></td>
            <td>
                <a href="<?= app()->route->getUrl('/department/edit').'?id='.htmlspecialchars($d->id) ?>">Редактировать</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
