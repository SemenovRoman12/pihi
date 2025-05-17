<?php
/** @var \Model\Discipline|null $discipline */
/** @var array|null            $errors  */
/** @var array|null            $old     */

$errors = $errors ?? [];
$old    = $old    ?? [];

$nameValue  = $old['name']  ?? ($discipline->name  ?? '');
$hoursValue = $old['hours'] ?? ($discipline->hours ?? '');
?>
<form method="post" class="p-4">
    <!-- Название -->
    <div class="mb-3">
        <label for="discName" class="form-label">Название дисциплины</label>
        <input  type="text"
                id="discName"
                name="name"
                class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                value="<?= htmlspecialchars($nameValue) ?>">

        <?php $field = 'name';
        require __DIR__ . '/../components/field-error.php'; ?>
    </div>

    <!-- Часы -->
    <div class="mb-3">
        <label for="discHours" class="form-label">Часы</label>
        <input  type="number"
                id="discHours"
                name="hours"
                class="form-control <?= isset($errors['hours']) ? 'is-invalid' : '' ?>"
                value="<?= htmlspecialchars($hoursValue) ?>">

        <?php $field = 'hours';
        require __DIR__ . '/../components/field-error.php'; ?>
    </div>

    <button class="btn btn-success">Сохранить</button>
</form>
