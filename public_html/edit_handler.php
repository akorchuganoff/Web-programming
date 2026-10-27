<?php
// edit_handler.php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $name = $conn->real_escape_string($_POST['name']);
    $surname = $conn->real_escape_string($_POST['surname']);
    $about = $conn->real_escape_string($_POST['about']);
    
    // Формируем базовый SQL-запрос на обновление
    $sql = "UPDATE user SET name='$name', surname='$surname', about='$about'";
    
    // Если ввели новый пароль, хешируем его и добавляем в запрос
    if (!empty($_POST['password'])) {
        $hashed_password = md5(sha1($_POST['password']));
        $sql .= ", password='$hashed_password'";
    }
    
    // Условие: обновляем только нужного пользователя по email
    $sql .= " WHERE email='$email'";

    if ($conn->query($sql) === TRUE) {
        echo "<h3>Данные успешно обновлены!</h3>";
        echo "<p><a href='index.php'>На главную</a></p>";
    } else {
        echo "Ошибка обновления: " . $conn->error;
    }
}
?>
