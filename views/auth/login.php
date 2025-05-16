
<h2>Вход</h2>

<?php if (!empty($error)): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="post" action="<?= app()->route->getUrl('/login') ?>">
    <label>
        Логин<br>
        <input type="text" name="login" required>
    </label><br><br>

    <label>
        Пароль<br>
        <input type="password" name="password" required>
    </label><br><br>

    <button type="submit">Войти</button>
</form>
