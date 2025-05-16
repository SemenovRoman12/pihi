<?php
/** @var \Model\Employee[]  $employees */
/** @var \Model\Department[] $departments */
/** @var \Model\Discipline[] $disciplines */
?>
<h2>Сотрудники</h2>

<form method="get">
    <?php foreach ($departments as $d): ?>
        <label>
            <input type="checkbox" name="department[]" value="<?= $d->id ?>"
                <?= in_array($d->id, $_GET['department'] ?? []) ? 'checked':'' ?>>
            <?= $d->name ?>
        </label>
    <?php endforeach; ?>
    <br>
    <?php foreach ($disciplines as $d): ?>
        <label>
            <input type="checkbox" name="discipline[]" value="<?= $d->id ?>"
                <?= in_array($d->id, $_GET['discipline'] ?? []) ? 'checked':'' ?>>
            <?= $d->name ?>
        </label>
    <?php endforeach; ?>
    <br><button type="submit">Фильтр</button>
</form>

<a href="<?= app()->route->getUrl('/employees/create') ?>">Добавить</a>

<table>
    <tr>
        <th>ФИО</th><th>Должность</th><th>Кафедры</th><th>Дисциплины</th><th></th>
    </tr>
    <?php foreach ($employees as $e): ?>
        <tr>
            <td><?= $e->full_name ?></td>
            <td><?= $e->position->name ?></td>
            <td><?= implode(', ', $e->departments->pluck('name')->all()) ?></td>
            <td><?= implode(', ', $e->disciplines->pluck('name')->all()) ?></td>
            <td>
                <a href="<?= app()->route->getUrl('/employees/edit').'?id='.$e->id ?>">редактировать</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
