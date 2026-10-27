<?php
// register.php
include 'header.php';
?>

<h3>Регистрация нового пользователя</h3>
<form action="register_handler.php" method="POST">
    <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div class="form-group">
        <label for="name">Имя:</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div class="form-group">
        <label for="surname">Фамилия:</label>
        <input type="text" name="surname" id="surname">
    </div>
    <div class="form-group">
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required>
    </div>
    <button type="submit">Зарегистрироваться</button>
</form>

<?php include 'footer.php'; ?>
