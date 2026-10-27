<?php
// delete.php
require 'db.php';

// Получаем email из URL
if (isset($_GET['email']) && !empty($_GET['email'])) {
    $email = $conn->real_escape_string($_GET['email']);

    // 1. Получаем информацию о фото пользователя перед удалением
    $result = $conn->query("SELECT photo FROM user WHERE email = '$email'");
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // 2. Если поле photo не пустое, пытаемся удалить файл
        if (!empty($user['photo'])) {
            $filePath = "img/" . $user['photo'];
            // Проверяем, существует ли файл на диске
            if (file_exists($filePath)) {
                unlink($filePath); // Удаляем файл
            }
        }

        // 3. Удаляем запись из базы данных
        $sql = "DELETE FROM user WHERE email = '$email'";
        if ($conn->query($sql) === TRUE) {
            // Успешно удалено, перенаправляем обратно к списку
            header("Location: users.php");
            exit();
        } else {
            echo "Ошибка при удалении из БД: " . $conn->error;
        }
    } else {
        echo "Пользователь не найден.";
    }
} else {
    echo "Не указан email для удаления.";
}
?>
