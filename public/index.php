<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная страница</title>
    <link rel="stylesheet" href="/./css/styles.css">
</head>
<body>

<h1>Добро пожаловать в систему учета оборудования</h1>

<div class="container">
    <a href="equipment/equipment_list.php">
        <div class="tile">
            <h2>Перечень оборудования</h2>
        </div>
    </a>
    <a href="employees/employee_list.php">
        <div class="tile">
            <h2>Перечень сотрудников</h2>
        </div>
    </a>
    <a href="equipment/equipment_usage.php">
        <div class="tile">
            <h2>Использование оборудования</h2>
        </div>
    </a>
</div>

<p><a href="auth/logout.php">Выйти</a></p>

</body>
</html>
