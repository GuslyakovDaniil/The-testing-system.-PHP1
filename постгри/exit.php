<?php
// Инициализация сессии
session_start();

// Уничтожение всех данных сессии
session_destroy();

// Редирект на страницу входа или другую нужную страницу
// header('Location: login.php');
// exit();

echo 'Вы успешно вышли.';
?>