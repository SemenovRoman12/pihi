<h2>Сотрудники</h2>

<!-- ФИЛЬТРЫ -------------------------------------------------------------->
<form id="filterForm" method="get">
    <!-- ПОИСК ПО ФИО ---------------------------------------------------------->
    <label style="display:block;">
        <input type="text" name="fio"
               value="<?= htmlspecialchars($_GET['fio'] ?? '') ?>"
               placeholder="Поиск по ФИО"
               class="search-fio-input">
    </label>

    <fieldset style="border:1px solid #ccc;padding:10px;margin-bottom:15px">
        <legend>Кафедры</legend>
        <?php foreach ($departments as $d): ?>
            <label style="display:inline-block;width:180px">
                <input type="checkbox"
                       name="department[]"
                       value="<?= $d->id ?>"
                    <?= in_array($d->id, $_GET['department'] ?? []) ? 'checked' : '' ?>>
                <?= $d->name ?>
            </label>
        <?php endforeach; ?>
    </fieldset>

    <fieldset style="border:1px solid #ccc;padding:10px;margin-bottom:15px">
        <legend>Дисциплины</legend>
        <?php foreach ($disciplines as $d): ?>
            <label style="display:inline-block;width:180px">
                <input type="checkbox"
                       name="discipline[]"
                       value="<?= $d->id ?>"
                    <?= in_array($d->id, $_GET['discipline'] ?? []) ? 'checked' : '' ?>>
                <?= $d->name ?>
            </label>
        <?php endforeach; ?>
    </fieldset>

    <button type="submit" style="display:none">Фильтр</button>
</form>

<script>
    // автоматическая отправка формы при изменении чек-боксов
    document.querySelectorAll('#filterForm input[type="checkbox"]')
        .forEach(cb => cb.addEventListener('change', () => cb.form.submit()));
</script>

<a href="<?= app()->route->getUrl('/employees/create') ?>">Добавить</a>

<table>
    <tr>
        <th>ФИО</th>
        <th>Должность</th>
        <th>Кафедры</th>
        <th>Дисциплины</th>
        <th></th>
    </tr>
    <?php foreach ($employees as $e): ?>
        <tr>
            <td><?= $e->full_name ?></td>
            <td><?= $e->position->name ?></td>
            <td><?= implode(', ', $e->departments->pluck('name')->all()) ?></td>
            <td><?= implode(', ', $e->disciplines->pluck('name')->all()) ?></td>
            <td>
                <a href="<?= app()->route->getUrl('/employees/edit') . '?id=' . $e->id ?>">
                    редактировать
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
