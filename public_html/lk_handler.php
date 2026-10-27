<?php
// lk_handler.php
session_start();
require 'db.php';

if (!isset($_SESSION['user_email'])) {
    die("Доступ запрещен.");
}

$email = $_SESSION['user_email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $position = $_POST['position'];
    $about = $_POST['about'];

    // Получаем текущую дату регистрации из БД
    $stmt = $pdo->prepare("SELECT regdate, photo FROM user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $regdate = $user['regdate'];

    // Обработка загрузки файла
    $photo_name = $user['photo']; // По умолчанию оставляем старое фото
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['photo']['tmp_name'];
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        
        // Формируем имя файла по заданию: логин (email) + время регистрации
        // Для безопасности убираем символ @ из email, чтобы не было проблем с путями
        $safe_email = str_replace('@', '_', $email);
        $photo_name = $safe_email . '_' . $regdate . '.' . $ext;
        
        // Перемещаем файл в папку img/
        move_uploaded_file($tmp_name, __DIR__ . '/img/' . $photo_name);
    }

    // Обновляем все данные в БД
    $sql = "UPDATE user SET name=?, surname=?, position=?, about=?, photo=? WHERE email=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $surname, $position, $about, $photo_name, $email]);

    header("Location: lk.php");
    exit();
}
?>
