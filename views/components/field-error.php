<?php
if (!empty($errors[$field])): ?>
    <?php foreach ($errors[$field] as $msg): ?>
        <div class="invalid-feedback d-block" style="color: red"><?= htmlspecialchars($msg) ?></div>
    <?php endforeach; ?>
<?php endif;
