<?php
require_once '../lib/connect.php';
require_once '../lib/function_global.php';

check_auth();

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($link, $query);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'change_password' && isset($_POST['user_id'])) {
            $target_user_id = $_POST['user_id'];
            $new_password = $_POST['new_password'];
            
            // Проверяем права
            if ($target_user_id != $user_id && (!$user['is_admin'] || (mysqli_fetch_assoc(mysqli_query($link, "SELECT is_admin FROM users WHERE id='$target_user_id'"))['is_admin']))) {
                $_SESSION['error'] = 'Недостаточно прав';
            } else {
                $salt = generate_salt();
                $hashed_password = hash_password($new_password, $salt);
                mysqli_query($link, "UPDATE users SET password='$hashed_password', salt='$salt' WHERE id='$target_user_id'");
                $_SESSION['success'] = 'Пароль успешно изменен';
            }
        } elseif ($_POST['action'] === 'delete_user' && $user['is_admin'] && isset($_POST['user_id'])) {
            $target_user_id = $_POST['user_id'];
            if (!mysqli_fetch_assoc(mysqli_query($link, "SELECT is_admin FROM users WHERE id='$target_user_id'"))['is_admin']) {
                mysqli_query($link, "DELETE FROM users WHERE id='$target_user_id'");
                $_SESSION['success'] = 'Пользователь удален';
            } else {
                $_SESSION['error'] = 'Нельзя удалить администратора';
            }
        }
    }
}

$users = mysqli_query($link, "SELECT * FROM users ORDER BY id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Главная страница</title>
    <meta charset="utf-8">
</head>
<body>
    <h2>Добро пожаловать, <?php echo htmlspecialchars($_SESSION['login']); ?>!</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success'])): ?>
        <p style="color: green;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
    <?php endif; ?>
    
    <?php if ($user['is_admin']): ?>
        <h3>Список пользователей:</h3>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Логин</th>
                <th>Админ</th>
                <th>Дата регистрации</th>
                <th>Действия</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($users)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['login']); ?></td>
                    <td><?php echo $row['is_admin'] ? 'Да' : 'Нет'; ?></td>
                    <td><?php echo $row['reg_date']; ?></td>
                    <td>
                        <?php if (!$row['is_admin'] || $row['id'] == $user_id): ?>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="change_password">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <input type="password" name="new_password" placeholder="Новый пароль" required>
                                <input type="submit" value="Изменить пароль">
                            </form>
                        <?php endif; ?>
                        
                        <?php if (!$row['is_admin'] && $row['id'] != $user_id): ?>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete_user">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <input type="submit" value="Удалить" onclick="return confirm('Вы уверены?')">
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <form method="POST">
            <input type="hidden" name="action" value="change_password">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="password" name="new_password" placeholder="Новый пароль" required>
            <input type="submit" value="Изменить свой пароль">
        </form>
    <?php endif; ?>
    
    <p>
        <a href="/registration/template/auth.php?logout=1">Выйти</a>
    </p>
</body>
</html>
