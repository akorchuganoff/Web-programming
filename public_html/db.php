<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// db.php
$db_type = 'mysql'; // В конце лабы поменяем на 'sqlite'

if ($db_type === 'mysql') {
    $host = 'localhost';
    $dbname = 'lab01_db'; // Твоя база
    $user = 'root';
    $pass = '';
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
} else {
    // Настройки для SQLite
    $dsn = "sqlite:" . __DIR__ . "/database.sqlite";
    $user = null;
    $pass = null;
}

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}
?>
