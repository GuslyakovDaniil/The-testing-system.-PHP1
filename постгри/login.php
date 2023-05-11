<?php
// Подключение к базе данных PgAdmin4
$dbhost = 'localhost'; // адрес хоста базы данных
$dbname = 'testingsystem'; // имя базы данных
$dbuser = 'postgres'; // имя пользователя базы данных
$dbpass = 'mysql'; // пароль пользователя базы данных

try {
    $dbh = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Подключение не удалось: ' . $e->getMessage());
}

// Обработка отправленной формы входа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверка наличия пользователя в базе данных
    $stmt = $dbh->prepare("SELECT password FROM users WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Проверка пароля
        $hashedPassword = $row['password'];
        if (password_verify($password, $hashedPassword)) {
            // Установка сессии для авторизованного пользователя
            session_start();
            $_SESSION['username'] = $username;
            echo 'Вы успешно вошли на сайт.';
            // Редирект на защищенную страницу
            header('Location: register.php');
            exit();
        } else {
            echo 'Неверный пароль.';
        }
    } else {
        echo 'Пользователь не найден.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Вход</title>
</head>
<body>
    <h2>Вход</h2>
    <form method="POST" action="">
        <label>Имя пользователя:</label>
        <input type="text" name="username" required><br><br>
        <label>Пароль:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Войти">
    </form>
</body>
</html>
