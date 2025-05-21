<?php

$errors = $errors ?? [];
$old    = $old    ?? [];

$isEdit = isset($employee);

$action = $isEdit
    ? '/employee/edit?id=' . $employee->id
    : '/employee/create';

$selectedDeps = $old['department']    ?? ($isEdit ? $employee->departments->pluck('id')->all()  : []);
$selectedDis  = $old['discipline']    ?? ($isEdit ? $employee->disciplines->pluck('id')->all() : []);

$lastName  = $old['last_name']   ?? ($employee->last_name   ?? '');
$firstName = $old['first_name']  ?? ($employee->first_name  ?? '');
$middleName= $old['middle_name'] ?? ($employee->middle_name ?? '');
$gender    = $old['gender']      ?? ($employee->gender      ?? 'male');
$birthDate = $old['birth_date']  ?? ($employee->birth_date  ?? '');
$address   = $old['address']     ?? ($employee->address     ?? '');
$position  = $old['position_id'] ?? ($employee->position_id ?? '');

?>
<h2><?= $isEdit ? 'Редактировать сотрудника' : 'Новый сотрудник' ?></h2>

<form method="post" action="<?= app()->route->getUrl($action) ?>" class="p-4">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>

    <label class="d-block mb-2">Фамилия
        <input type="text" name="last_name"
               class="form-control <?= isset($errors['fio']) ? 'is-invalid' : '' ?>"
               value="<?= htmlspecialchars($lastName) ?>" required>
    </label>
    <?php $field='fio'; require __DIR__.'/../components/field-error.php'; ?>

    <label class="d-block mb-2">Имя
        <input type="text" name="first_name"
               class="form-control <?= isset($errors['fio']) ? 'is-invalid' : '' ?>"
               value="<?= htmlspecialchars($firstName) ?>" required>
    </label>

    <label class="d-block mb-2">Отчество
        <input type="text" name="middle_name"
               class="form-control <?= isset($errors['fio']) ? 'is-invalid' : '' ?>"
               value="<?= htmlspecialchars($middleName) ?>">
    </label>

    <label class="d-block mb-2">Пол
        <select name="gender" class="form-select">
            <option value="male"   <?= $gender==='male'   ? 'selected' : '' ?>>Муж.</option>
            <option value="female" <?= $gender==='female' ? 'selected' : '' ?>>Жен.</option>
        </select>
    </label>

    <label class="d-block mb-2">Дата&nbsp;рождения
        <input type="date" name="birth_date"
               class="form-control <?= isset($errors['birth_date']) ? 'is-invalid' : '' ?>"
               value="<?= htmlspecialchars($birthDate) ?>" required>
    </label>
    <?php $field='birth_date'; require __DIR__.'/../components/field-error.php'; ?>

    <label class="d-block mb-2">Адрес
        <input type="text" name="address"
               class="form-control"
               value="<?= htmlspecialchars($address) ?>" required>
    </label>

    <label class="d-block mb-2">Должность
        <select name="position_id" class="form-select">
            <?php foreach ($positions as $p): ?>
                <option value="<?= $p->id ?>" <?= $position == $p->id ? 'selected' : '' ?>>
                    <?= $p->name ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <?php if (!$isEdit): ?>
        <label class="d-block mb-2">Логин
            <input type="text" name="login"
                   class="form-control <?= isset($errors['login']) ? 'is-invalid' : '' ?>"
                   value="<?= htmlspecialchars($old['login'] ?? '') ?>" required>
        </label>
        <?php $field='login'; require __DIR__.'/../components/field-error.php'; ?>

        <label class="d-block mb-2">Пароль
            <input type="password" name="password"
                   class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" required>
        </label>
        <?php $field='password'; require __DIR__.'/../components/field-error.php'; ?>
    <?php endif; ?>

    <p>Кафедры:</p>
    <?php foreach ($departments as $d): ?>
        <label class="me-3">
            <input type="checkbox" name="department[]" value="<?= $d->id ?>"
                <?= in_array($d->id, $selectedDeps) ? 'checked' : '' ?>>
            <?= $d->name ?>
        </label>
    <?php endforeach; ?>

    <p class="mt-3">Дисциплины:</p>
    <?php foreach ($disciplines as $d): ?>
        <label class="me-3">
            <input type="checkbox" name="discipline[]" value="<?= $d->id ?>"
                <?= in_array($d->id, $selectedDis) ? 'checked' : '' ?>>
            <?= $d->name ?>
        </label>
    <?php endforeach; ?>

    <br><br>
    <button type="submit" class="btn btn-success"><?= $isEdit ? 'Сохранить' : 'Создать' ?></button>
</form>
