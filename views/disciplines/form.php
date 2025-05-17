<?php
use Model\Discipline;

$isEdit = isset($discipline);
$action = $isEdit ? '/discipline/edit?id='.$discipline->id : '/discipline/create';
?>
<h2>Дисциплина</h2>
<form method="post" action="<?= app()->route->getUrl($action) ?>">
    <input type="text"   name="name"  placeholder="Название"
           value="<?= $discipline->name  ?? '' ?>" required>
    <input type="number" step="0.01" name="hours" placeholder="Кол-во часов"
           value="<?= $discipline->hours ?? '' ?>" required>
    <button type="submit"><?= $isEdit ? 'Сохранить' : 'Добавить' ?></button>
</form>
