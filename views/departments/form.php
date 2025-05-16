<?php
/** @var Department|null $department */

use Model\Department;

$isEdit = isset($department);
$action = $isEdit ? '/department/edit?id='.$department->id : '/department/create';
?>
<h2>Кафедра</h2>
<form method="post" action="<?= app()->route->getUrl($action) ?>">
    <input type="text" name="name" placeholder="Название"
           value="<?= $department->name ?? '' ?>" required>
    <button type="submit"><?= $isEdit ? 'Сохранить' : 'Добавить' ?></button>
</form>
