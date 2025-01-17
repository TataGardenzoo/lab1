<?php
$host = 'localhost';
$database = 'mysite';
$user = 'root';
$password = '';

$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка подключения к базе данных" . mysqli_error($link));
?>
