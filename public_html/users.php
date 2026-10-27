<?php
// users.php
require 'db.php';
include 'header.php';

// --- БЛОК ПОИСКА ---
// Получаем параметры поиска из URL (метод GET)
$search_name = isset($_GET['search_name']) ? $conn->real_escape_string($_GET['search_name']) : '';
$search_surname = isset($_GET['search_surname']) ? $conn->real_escape_string($_GET['search_surname']) : '';
$search_email = isset($_GET['search_email']) ? $conn->real_escape_string($_GET['search_email']) : '';

// Базовый запрос
$sql = "SELECT * FROM user WHERE 1=1";

// Если поля поиска заполнены, добавляем условия (приблизительный поиск через LIKE)
if (!empty($search_name)) {
    $sql .= " AND name LIKE '%$search_name%'";
}
if (!empty($search_surname)) {
    $sql .= " AND surname LIKE '%$search_surname%'";
}
if (!empty($search_email)) {
    $sql .= " AND email LIKE '%$search_email%'";
}

$sql .= " ORDER BY regdate DESC"; // Сначала новые
$result = $conn->query($sql);
?>

<h3>Список пользователей</h3>

<!-- Ссылка на добавление вверху -->
<p><a href="register.php">➕ Добавить нового пользователя</a></p>

<!-- Форма поиска -->
<form method="GET" action="users.php" style="background: #f9f9f9; padding: 10px; margin-bottom: 20px;">
    <strong>Поиск:</strong>
    <input type="text" name="search_name" placeholder="Имя" value="<?php echo htmlspecialchars($search_name); ?>">
    <input type="text" name="search_surname" placeholder="Фамилия" value="<?php echo htmlspecialchars($search_surname); ?>">
    <input type="text" name="search_email" placeholder="E-mail" value="<?php echo htmlspecialchars($search_email); ?>">
    <button type="submit">Искать</button>
    <a href="users.php">Сбросить</a>
</form>

<!-- Таблица с результатами -->
<table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <tr style="background: #eee;">
        <th>E-mail</th>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Дата регистрации</th>
        <th>Действия</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Форматируем дату в привычный вид
            $formatted_date = date('d.m.Y H:i', $row['regdate']);
            
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['surname'] ?? '—') . "</td>";
            echo "<td>" . $formatted_date . "</td>";
            echo "<td>
                    <a href='edit.php?email=" . urlencode($row['email']) . "'>✏️ Ред.</a> | 
                    <a href='delete.php?email=" . urlencode($row['email']) . "' onclick=\"return confirm('Удалить пользователя и его фото?');\">❌ Удалить</a>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5' style='text-align:center;'>Пользователи не найдены.</td></tr>";
    }
    ?>
</table>

<!-- Ссылка на добавление внизу -->
<p><a href="register.php">➕ Добавить нового пользователя</a></p>

<?php include 'footer.php'; ?>
