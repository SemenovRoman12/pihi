<form method="post" class="p-4">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <div class="mb-3">
        <label for="depName" class="form-label">Название кафедры</label>
        <input  type="text"
                id="depName"
                name="name"
                class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                value="<?= htmlspecialchars($department->name ?? ($_POST['name'] ?? '')) ?>">

        <?php $field = 'name';
        require __DIR__ . '/../components/field-error.php'; ?>
    </div>

    <button class="btn btn-success">Сохранить</button>
</form>
