<?php
// index.php
session_start(); // ОБЯЗАТЕЛЬНО в самом верху для работы сессий!
require 'db.php'; // Подключает $pdo

// Если пользователь уже авторизован, сразу отправляем его в личный кабинет
if (isset($_SESSION['user_email'])) {
    header("Location: lk.php");
    exit();
}

include 'header.php'; // Шапка сайта
?>

<h3>Вход в систему</h3>
<form action="index.php" method="POST">
    <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div class="form-group">
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required>
    </div>
    <button type="submit">Войти</button>
</form>

<p>Нет аккаунта? <a href="register.php">Зарегистрируйтесь!</a></p>

<?php
// Обработка формы входа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    // Хешируем пароль так же, как при регистрации
    $password = md5(sha1($_POST['password']));
    
    // Ищем пользователя в БД через PDO
    $stmt = $pdo->prepare("SELECT email FROM user WHERE email = ? AND password = ?");
    $stmt->execute([$email, $password]);
    
    if ($stmt->rowCount() === 1) {
        // Успешный вход: записываем email в сессию
        $_SESSION['user_email'] = $email;
        
        // Перенаправляем в личный кабинет
        header("Location: lk.php");
        exit();
    } else {
        echo "<p style='color:red;'>Неверный email или пароль.</p>";
    }
}

include 'footer.php'; // Подвал сайта
?>
