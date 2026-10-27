<?php
// header.php
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мой Сайт - Лабораторная 2</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { background: #eee; padding: 10px; margin-bottom: 20px; }
        .footer { background: #eee; padding: 10px; margin-top: 20px; text-align: center; }
        .form-group { margin-bottom: 10px; }
        label { display: inline-block; width: 100px; }
        input[type="text"], input[type="password"], input[type="email"], textarea { width: 200px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Мой локальный сайт (XAMPP)</h2>
        <a href="index.php">Главная (Вход)</a> | 
        <a href="register.php">Регистрация</a>
	<a href="users.php">Список пользователей</a> 
    </div>
    <div class="content">
