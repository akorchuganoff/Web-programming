<?php
// init_sqlite.php
$dsn = "sqlite:" . __DIR__ . "/database.sqlite";
$pdo = new PDO($dsn);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Создаем таблицу
$sql = "CREATE TABLE IF NOT EXISTS user (
    email VARCHAR(255) PRIMARY KEY,
    surname VARCHAR(255) DEFAULT NULL,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(40) NOT NULL,
    regdate INTEGER NOT NULL,
    photo VARCHAR(255) DEFAULT NULL,
    position INTEGER DEFAULT NULL,
    about TEXT
)";
$pdo->exec($sql);

echo "База SQLite создана! Можете удалить этот файл.";
?>
