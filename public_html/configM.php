<?php
// phpinfo(); // Закомментировали, как просили в задании

$host = 'localhost';
$user = 'root';       // Стандартный юзер в XAMPP
$password = '';       // Пароль от БД (если пустой, оставь кавычки пустыми)
$dbname = 'lab01_db'; // Имя базы, которую ты создал

// Подключение
$conn = new mysqli($host, $user, $password, $dbname);

// Проверка
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
echo "<h1>Успешное подключение к MariaDB!</h1>";
?>
