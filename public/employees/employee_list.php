<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Repositories/EmployeeRepository.php';

use App\Repositories\EmployeeRepository;
use App\Models\Employee;

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$connection = getConnection();
$employeeRepository = new EmployeeRepository($connection);

// Получение списка сотрудников
$employees = $employeeRepository->getAllEmployees();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['full_name'] ?? '';
    $inn = $_POST['inn'] ?? '';
    $phoneNumber = $_POST['phone_number'] ?? '';
    $email = $_POST['email'] ?? '';
    $position = $_POST['position'] ?? '';
    $department = $_POST['department'] ?? '';

    if (!empty($fullName) && !empty($inn) && !empty($phoneNumber) && !empty($email) && !empty($position) && !empty($department)) {
        $employee = new Employee($fullName, $inn, $phoneNumber, $email, $position, $department);
        $employeeRepository->addEmployee($employee);

        header('Location: employee_list.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Перечень сотрудников</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Перечень сотрудников</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>ФИО</th>
        <th>ИНН</th>
        <th>Номер телефона</th>
        <th>Email</th>
        <th>Должность</th>
        <th>Отдел</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($employees as $employee) : ?>
        <tr>
            <td><?php echo $employee['id']; ?></td>
            <td><?php echo $employee['full_name']; ?></td>
            <td><?php echo $employee['inn']; ?></td>
            <td><?php echo $employee['phone_number']; ?></td>
            <td><?php echo $employee['email']; ?></td>
            <td><?php echo $employee['position']; ?></td>
            <td><?php echo $employee['department']; ?></td>
            <td>
                <a href="edit_employee.php?id=<?php echo $employee['id']; ?>">Редактировать</a> |
                <a href="delete_employee.php?id=<?php echo $employee['id']; ?>">Удалить</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Добавить нового сотрудника</h3>
<form method="post" action="employee_list.php">
    <label for="full_name">ФИО:</label>
    <input type="text" name="full_name" id="full_name" required>
    <br>
    <label for="inn">ИНН:</label>
    <input type="text" name="inn" id="inn" required>
    <br>
    <label for="phone_number">Номер телефона:</label>
    <input type="text" name="phone_number" id="phone_number" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="position">Должность:</label>
    <input type="text" name="position" id="position" required>
    <br>
    <label for="department">Отдел:</label>
    <input type="text" name="department" id="department" required>
    <br>
    <button type="submit">Добавить</button>
</form>

<p><a href="/public/index.php">Вернуться на главную</a></p>

</body>
</html>
