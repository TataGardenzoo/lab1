<?php
require_once 'lib/connect.php';
require_once 'lib/function_global.php';

if (isset($_SESSION['auth']) && $_SESSION['auth']) {
    header("Location: /main/main.php");
    exit();
} else {
    header("Location: /registration/template/auth.php");
    exit();
}
?>
