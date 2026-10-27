<?php
// lk.php
session_start();
require 'db.php';
include 'header.php';

// Проверка авторизации
if (!isset($_SESSION['user_email'])) {
    die("Вы не авторизованы. <a href='index.php'>Войти</a>");
}

$email = $_SESSION['user_email'];

// Получаем данные текущего пользователя
$stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<h3>Личный кабинет: <?= htmlspecialchars($user['name']) ?></h3>

<form action="lk_handler.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label>E-mail (не меняется):</label>
        <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
    </div>
    <div class="form-group">
        <label>Дата регистрации:</label>
        <input type="text" value="<?= date('d.m.Y H:i', $user['regdate']) ?>" disabled>
    </div>
    
    <div class="form-group">
        <label>Имя:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
    </div>
    <div class="form-group">
        <label>Фамилия:</label>
        <input type="text" name="surname" value="<?= htmlspecialchars($user['surname'] ?? '') ?>">
    </div>
    
    <div class="form-group">
        <label>Статус (Должность):</label>
        <select name="position">
            <option value="1" <?= $user['position'] == 1 ? 'selected' : '' ?>>Студент</option>
            <option value="2" <?= $user['position'] == 2 ? 'selected' : '' ?>>Преподаватель</option>
            <option value="3" <?= $user['position'] == 3 ? 'selected' : '' ?>>Администратор</option>
        </select>
    </div>

    <div class="form-group">
        <label>О себе:</label><br>
        <textarea name="about" rows="4"><?= htmlspecialchars($user['about'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label>Фото профиля:</label><br>
        <?php if (!empty($user['photo'])): ?>
            <img src="img/<?= htmlspecialchars($user['photo']) ?>" width="100"><br>
        <?php endif; ?>
        <input type="file" name="photo" accept="image/*">
    </div>

    <button type="submit">Сохранить изменения</button>
    <a href="logout.php" style="margin-left: 20px; color: red;">Выйти из системы</a>
</form>

<?php include 'footer.php'; ?>
