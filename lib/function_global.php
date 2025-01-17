<?php
session_start();

function check_auth() {
    if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
        header("Location: /registration/template/auth.php");
        exit();
    }
}

function check_admin() {
    if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
        header("Location: /main/main.php");
        exit();
    }
}

function generate_salt() {
    return substr(md5(uniqid(rand(), true)), 0, 10);
}

function hash_password($password, $salt) {
    return md5($password . $salt);
}
?>
