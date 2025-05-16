<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Уч-мет управление</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header>
    <nav>
        <?php if (!app()->auth::check()): ?>
            <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
        <?php else: ?>
            <a href="<?= app()->route->getUrl('/')   ?>">Главная</a>
            <a href="<?= app()->route->getUrl('/employees')   ?>">Сотрудники</a>
            <a href="<?= app()->route->getUrl('/departments') ?>">Кафедры</a>
            <a href="<?= app()->route->getUrl('/disciplines') ?>">Дисциплины</a>
            <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth::user()->login ?>)</a>
        <?php endif; ?>
    </nav>
</header>
<main>
    <?= $content ?? '' ?>
</main>
</body>
</html>
