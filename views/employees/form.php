<?php
$isEdit       = isset($employee);
$action       = $isEdit
    ? '/employees/edit?id=' . $employee->id
    : '/employees/create';
$selectedDeps = $isEdit ? $employee->departments->pluck('id')->all()  : [];
$selectedDis  = $isEdit ? $employee->disciplines->pluck('id')->all() : [];
?>
<h2><?= $isEdit ? 'Редактировать сотрудника' : 'Новый сотрудник' ?></h2>

<form method="post" action="<?= app()->route->getUrl($action) ?>">
    <label>Фамилия
        <input type="text" name="last_name"
               value="<?= $isEdit ? $employee->last_name : '' ?>" required>
    </label><br>

    <label>Имя
        <input type="text" name="first_name"
               value="<?= $isEdit ? $employee->first_name : '' ?>" required>
    </label><br>

    <label>Отчество
        <input type="text" name="middle_name"
               value="<?= $isEdit ? $employee->middle_name : '' ?>">
    </label><br>

    <label>Пол
        <select name="gender">
            <option value="male"   <?= $isEdit && $employee->gender==='male'   ? 'selected' : '' ?>>Муж.</option>
            <option value="female" <?= $isEdit && $employee->gender==='female' ? 'selected' : '' ?>>Жен.</option>
        </select>
    </label><br>

    <label>Дата&nbsp;рождения
        <input type="date" name="birth_date"
               value="<?= $isEdit ? $employee->birth_date : '' ?>" required>
    </label><br>

    <label>Адрес
        <input type="text" name="address"
               value="<?= $isEdit ? $employee->address : '' ?>" required>
    </label><br>

    <label>Должность
        <select name="position_id">
            <?php foreach ($positions as $p): ?>
                <option value="<?= $p->id ?>"
                    <?= $isEdit && $employee->position_id == $p->id ? 'selected' : '' ?>>
                    <?= $p->name ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br>

    <?php if (!$isEdit): /* логин/пароль только при создании */ ?>
        <label>Логин
            <input type="text" name="login" required>
        </label><br>

        <label>Пароль
            <input type="password" name="password" required>
        </label><br>
    <?php endif; ?>

    <p>Кафедры:</p>
    <?php foreach ($departments as $d): ?>
        <label style="display:inline-block;width:180px">
            <input type="checkbox" name="department[]" value="<?= $d->id ?>"
                <?= in_array($d->id, $selectedDeps) ? 'checked' : '' ?>>
            <?= $d->name ?>
        </label>
    <?php endforeach; ?>

    <p>Дисциплины:</p>
    <?php foreach ($disciplines as $d): ?>
        <label style="display:inline-block;width:180px">
            <input type="checkbox" name="discipline[]" value="<?= $d->id ?>"
                <?= in_array($d->id, $selectedDis) ? 'checked' : '' ?>>
            <?= $d->name ?>
        </label>
    <?php endforeach; ?>

    <br><br>
    <button type="submit"><?= $isEdit ? 'Сохранить' : 'Создать' ?></button>
</form>
