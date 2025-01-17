<?php
require_once '../lib/connect.php';
require_once '../lib/function_global.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = mysqli_real_escape_string($link, $_POST['login']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    
    // Проверка существования пользователя
    $query = "SELECT id FROM users WHERE login='$login'";
    $result = mysqli_query($link, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = 'Пользователь с таким логином уже существует';
        header("Location: template/registration.php");
        exit();
    }
    
    if (strlen($login) < 3) {
        $_SESSION['error'] = 'Логин должен быть не менее 3 символов';
        header("Location: template/registration.php");
        exit();
    }
    
    if (strlen($password) < 6) {
        $_SESSION['error'] = 'Пароль должен быть не менее 6 символов';
        header("Location: template/registration.php");
        exit();
    }
    
    if ($password !== $password_confirm) {
        $_SESSION['error'] = 'Пароли не совпадают';
        header("Location: template/registration.php");
        exit();
    }
    
    $salt = generate_salt();
    $hashed_password = hash_password($password, $salt);
    $reg_date = date('Y-m-d H:i:s');
    
    $query = "INSERT INTO users (login, password, salt, is_admin, reg_date) 
              VALUES ('$login', '$hashed_password', '$salt', 0, '$reg_date')";
    
    if (mysqli_query($link, $query)) {
        header("Location: template/auth.php");
        exit();
    } else {
        $_SESSION['error'] = 'Ошибка при регистрации';
        header("Location: template/registration.php");
        exit();
    }
}
?>
