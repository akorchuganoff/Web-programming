<?php
// index.php
session_start();
require 'db.php';
include 'header.php';

// Если пользователь уже авторизован, отправляем его в личный кабинет
if (isset($_SESSION['user_email'])) {
    header("Location: lk.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = md5(sha1($_POST['password']));
    
    // Используем подготовленные выражения PDO для защиты от SQL-инъекций
    $stmt = $pdo->prepare("SELECT email FROM user WHERE email = ? AND password = ?");
    $stmt->execute([$email, $password]);
    
    if ($stmt->rowCount() === 1) {
        // Авторизация успешна - записываем email в сессию
        $_SESSION['user_email'] = $email;
        header("Location: lk.php");
        exit();
    } else {
        echo "<p style='color:red;'>Неверный email или пароль.</p>";
    }
}
?>
<!-- Форма входа остается прежней -->
<h3>Вход в систему</h3>
<form action="index.php" method="POST">
    <div class="form-group"><label>E-mail:</label><input type="email" name="email" required></div>
    <div class="form-group"><label>Пароль:</label><input type="password" name="password" required></div>
    <button type="submit">Войти</button>
</form>
<p>Нет аккаунта? <a href="register.php">Зарегистрируйтесь!</a></p>
<?php include 'footer.php'; ?>
