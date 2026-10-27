<?php
// phpinfo();

try {
    // Создаем или подключаемся к файлу БД (SQLite работает через PDO)
    $pdo = new PDO('sqlite:' . __DIR__ . '/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h1>Успешное подключение к SQLite!</h1>";

    // SQL-скрипт создания таблицы из задания
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
    
    // Выполняем скрипт
    $pdo->exec($sql);
    echo "<p>Таблица 'user' успешно создана в SQLite!</p>";

} catch (PDOException $e) {
    die("Ошибка SQLite: " . $e->getMessage());
}
?>
