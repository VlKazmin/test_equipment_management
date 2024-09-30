<?php

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Repositories/EmployeeRepository.php';

use App\Repositories\EmployeeRepository;

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$connection = getConnection();
$employeeRepository = new EmployeeRepository($connection);

// Проверка, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $fullName = $_POST['full_name'];
    $inn = $_POST['inn'];
    $phoneNumber = $_POST['phone_number'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $department = $_POST['department'];

    // Обновление данных сотрудника
    $employeeRepository->updateEmployee($id, $fullName, $inn, $phoneNumber, $email, $position, $department);

    header('Location: employee_list.php');
    exit;
}

$id = $_GET['id'];
$employee = $employeeRepository->getEmployeeById($id);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать сотрудника</title>
</head>
<body>
    <h1>Редактировать сотрудника</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $employee['id'] ?>">
        <label for="full_name">Полное имя:</label>
        <input type="text" id="full_name" name="full_name" value="<?= $employee['full_name'] ?>" required>
        <br>
        <label for="inn">ИНН:</label>
        <input type="text" id="inn" name="inn" value="<?= $employee['inn'] ?>" required>
        <br>
        <label for="phone_number">Номер телефона:</label>
        <input type="text" id="phone_number" name="phone_number" value="<?= $employee['phone_number'] ?>" required>
        <br>
        <label for="email">Электронная почта:</label>
        <input type="email" id="email" name="email" value="<?= $employee['email'] ?>" required>
        <br>
        <label for="position">Должность:</label>
        <input type="text" id="position" name="position" value="<?= $employee['position'] ?>" required>
        <br>
        <label for="department">Отдел:</label>
        <input type="text" id="department" name="department" value="<?= $employee['department'] ?>" required>
        <br>
        <button type="submit">Сохранить изменения</button>
    </form>
    <a href="employee_list.php">Вернуться к списку сотрудников</a>
</body>
</html>
