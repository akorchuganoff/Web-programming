<?php
// register_handler.php
require 'db.php'; // Подключает новый $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные (без real_escape_string, PDO сам защитит от инъекций)
    $email = $_POST['email'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $password = md5(sha1($_POST['password'])); // Двойное хеширование
    $regdate = time();

    // Проверяем, нет ли уже такого email
    $stmt = $pdo->prepare("SELECT email FROM user WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        die("Пользователь с таким email уже существует. <a href='register.php'>Назад</a>");
    }

    // Вставляем данные в таблицу user
    $sql = "INSERT INTO user (email, name, surname, password, regdate) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$email, $name, $surname, $password, $regdate])) {
        echo "<h3>Регистрация успешна!</h3>";
        echo "<p>Ваш хеш пароля: <b>$password</b></p>";
        echo "<p><a href='index.php'>Перейти на главную</a></p>";
    } else {
        echo "Ошибка при добавлении пользователя.";
    }
}
?>
