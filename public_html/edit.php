<?php
// edit.php
require 'db.php';
include 'header.php';

// Получаем email из URL (например, edit.php?email=alex@mail.ru)
$email = isset($_GET['email']) ? $conn->real_escape_string($_GET['email']) : '';

if (empty($email)) {
    die("Не указан email пользователя. <a href='index.php'>На главную</a>");
}

// Получаем данные пользователя из БД
$result = $conn->query("SELECT * FROM user WHERE email = '$email'");
if ($result->num_rows === 0) {
    die("Пользователь не найден.");
}
$user = $result->fetch_assoc();
?>

<h3>Редактирование профиля: <?php echo htmlspecialchars($user['email']); ?></h3>
<form action="edit_handler.php" method="POST">
    <!-- Передаем email скрытым полем, чтобы знать, кого обновлять -->
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
    
    <!-- Email и Дата регистрации НЕ редактируются (только для чтения) -->
    <div class="form-group">
        <label>E-mail (не менять):</label>
        <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
    </div>
    <div class="form-group">
        <label>Дата рег. (не менять):</label>
        <input type="text" value="<?php echo date('Y-m-d H:i', $user['regdate']); ?>" disabled>
    </div>

    <!-- Остальные поля редактируемые -->
    <div class="form-group">
        <label for="name">Имя:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
    </div>
    <div class="form-group">
        <label for="surname">Фамилия:</label>
        <input type="text" name="surname" id="surname" value="<?php echo htmlspecialchars($user['surname']); ?>">
    </div>
    <div class="form-group">
        <label for="about">О себе:</label><br>
        <textarea name="about" id="about" rows="4"><?php echo htmlspecialchars($user['about']); ?></textarea>
    </div>
    <div class="form-group">
        <label for="password">Новый пароль:</label>
        <input type="password" name="password" id="password" placeholder="Оставьте пустым, чтобы не менять">
    </div>
    
    <button type="submit">Сохранить изменения</button>
</form>

<?php include 'footer.php'; ?>
