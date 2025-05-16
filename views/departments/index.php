<?php /** @var Department[] $departments */

use Model\Department; ?>
<h2>Кафедры</h2>
<a href="<?= app()->route->getUrl('/department/create') ?>">Добавить</a>
<ul>
    <?php foreach ($departments as $d): ?>
        <li>
            <?= $d->name ?>
            (<a href="<?= app()->route->getUrl('/department/edit').'?id='.$d->id ?>">редактировать</a>)
        </li>
    <?php endforeach; ?>
</ul>
