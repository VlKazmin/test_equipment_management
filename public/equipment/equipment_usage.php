<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Repositories/EquipmentUsageRepository.php';
require_once __DIR__ . '/../../src/Repositories/EmployeeRepository.php';
require_once __DIR__ . '/../../src/Repositories/EquipmentRepository.php';

use App\Repositories\EquipmentUsageRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\EquipmentRepository;

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Подключение к базе данных
$connection = getConnection();
$equipmentUsageRepository = new EquipmentUsageRepository($connection);
$employeeRepository = new EmployeeRepository($connection);
$equipmentRepository = new EquipmentRepository($connection);

// Получение данных для отображения
$equipmentUsageList = $equipmentUsageRepository->getAllEquipmentUsages();
$employees = $employeeRepository->getAllEmployees();
$equipments = $equipmentRepository->getAllEquipments();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = $_POST['employee_id'] ?? '';
    $equipmentId = $_POST['equipment_id'] ?? '';
    $inventoryNumber = $_POST['inventory_number'] ?? '';

    if (!empty($employeeId) && !empty($equipmentId) && !empty($inventoryNumber)) {
        // Создание объекта EquipmentUsage
        $equipmentUsage = new App\Models\EquipmentUsage($employeeId, $equipmentId, $inventoryNumber, date('Y-m-d'));

        $equipmentUsageRepository->addEquipmentUsage($equipmentUsage);

        header('Location: equipment_usage.php');
        exit();
    } else {
        echo "Ошибка: Все поля должны быть заполнены!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Использование оборудования</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Использование оборудования</h2>

<table border="2">
    <thead>
        <tr>
            <th>ID</th>
            <th>Оборудование</th>
            <th>Инвентарный номер</th>
            <th>Статус</th>
            <th>Сотрудник</th>
            <th>Дата выдачи</th>
            <th>Дата возврата</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($equipmentUsageList)) : ?>
            <tr>
                <td colspan="8">Нет записей использования оборудования.</td>
            </tr>
        <?php else : ?>
            <?php foreach ($equipmentUsageList as $usage) : ?>
                <tr>
                    <td><?php echo $usage['id']; ?></td>
                    <td><?php echo $usage['equipment_name']; ?></td>
                    <td><?php echo $usage['inventory_number']; ?></td>
                    <td><?php echo $usage['status']; ?></td>
                    <td><?php echo $usage['employee_full_name']; ?></td>
                    <td><?php echo $usage['issue_date']; ?></td>
                    <td><?php echo $usage['return_date']; ?></td>
                    <td>
                        <?php if ($usage['status'] === 'в использовании') : ?>
                            <a href="return_equipment.php?id=<?php echo $usage['id']; ?>">Вернуть на склад</a> |
                        <?php endif; ?>
                        <a href="delete_equipment_usage.php?id=<?php echo $usage['id']; ?>">Удалить запись</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<h3>Добавить использование оборудования</h3>
<form method="post" action="equipment_usage.php">
    <label for="equipment_id">Оборудование:</label>
    <select name="equipment_id" id="equipment_id" required>
        <?php foreach ($equipments as $equipment) : ?>
            <option value="<?php echo $equipment->getId(); ?>"><?php echo $equipment->getName(); ?></option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for="inventory_number">Инвентарный номер:</label>
    <input type="text" name="inventory_number" id="inventory_number" required>
    <br>

    <label for="employee_id">Сотрудник:</label>
    <select name="employee_id" id="employee_id" required>
        <?php foreach ($employees as $employee) : ?>
            <option value="<?php echo $employee['id']; ?>"><?php echo $employee['full_name']; ?></option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for="status">Статус:</label>
    <select name="status" id="status">
        <option value="в использовании">В использовании</option>
        <option value="на складе">На складе</option>
    </select>
    <br>

    <button type="submit">Добавить</button>
</form>

<p><a href="/public/index.php">Вернуться на главную</a></p>


</body>
</html>
