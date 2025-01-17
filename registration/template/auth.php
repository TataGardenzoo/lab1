<?php
require_once '../../lib/connect.php';
require_once '../../lib/function_global.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = mysqli_real_escape_string($link, $_POST['login']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE login='$login'";
    $result = mysqli_query($link, $query);
    
    if ($user = mysqli_fetch_assoc($result)) {
        $hashed_password = hash_password($password, $user['salt']);
        
        if ($hashed_password === $user['password']) {
            $_SESSION['auth'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            $_SESSION['is_admin'] = $user['is_admin'];
            
            header("Location: /main/main.php");
            exit();
        }
    }
    $error = 'Неверный логин или пароль';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Авторизация</title>
    <meta charset="utf-8">
</head>
<body>
    <h2>Авторизация</h2>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <p>
            <label>Логин:</label><br>
            <input type="text" name="login" required>
        </p>
        <p>
            <label>Пароль:</label><br>
            <input type="password" name="password" required>
        </p>
        <p>
            <input type="submit" value="Войти">
        </p>
    </form>
    <p>
        <a href="registration.php">Зарегистрироваться</a>
    </p>
</body>
</html>
