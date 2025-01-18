<?php
require_once '../../lib/connect.php';
require_once '../../lib/function_global.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
    <meta charset="utf-8">
    <script src="/js/regform.js?v=<?php echo time(); ?>"></script>
</head>
<body>
    <h2>Регистрация</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>
    
    <form method="POST" action="../index.php" onsubmit="return validateForm(this);">
        <p>
            <label>Логин:</label><br>
            <input type="text" name="login" required>
        </p>
        <p>
            <label>Пароль:</label><br>
            <input type="password" name="password" required>
        </p>
        <p>
            <label>Подтверждение пароля:</label><br>
            <input type="password" name="password_confirm" required>
        </p>
        <p>
            <input type="submit" value="Зарегистрироваться">
        </p>
    </form>
    <p>
        <a href="auth.php">Вернуться к авторизации</a>
    </p>
</body>
</html>
