<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Repositories/EmployeeRepository.php';

use App\Repositories\EmployeeRepository;

$connection = getConnection();
$employeeRepository = new EmployeeRepository($connection);

// Проверка, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Удаление сотрудника
    $employeeRepository->deleteEmployee($id);

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
    <title>Удалить сотрудника</title>
</head>
<body>
    <h1>Удалить сотрудника</h1>
    <p>Вы уверены, что хотите удалить сотрудника <strong><?= htmlspecialchars($employee['full_name']) ?></strong>?</p>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $employee['id'] ?>">
        <button type="submit">Удалить</button>
    </form>
    <a href="employee_list.php">Отмена</a>
</body>
</html>
