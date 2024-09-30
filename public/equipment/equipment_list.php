<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Repositories/EquipmentRepository.php';

use App\Repositories\EquipmentRepository;
use App\Models\Equipment;

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit();
}

$connection = getConnection();
$equipmentRepository = new EquipmentRepository($connection);

// Получение списка оборудования
$equipments = $equipmentRepository->getAllEquipments();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $code = $_POST['code'] ?? '';

    if (!empty($name) && !empty($code)) {
        $equipment = new Equipment(null, $name, $code);
        $equipmentRepository->addEquipment($equipment);

        header('Location: equipment_list.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Перечень оборудования</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Перечень оборудования</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Код</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($equipments as $equipment) : ?>
        <tr>
            <td><?php echo $equipment->getId(); ?></td>
            <td><?php echo $equipment->getName(); ?></td>
            <td><?php echo $equipment->getCode(); ?></td>
            <td>
                <a href="edit_equipment.php?id=<?php echo $equipment->getId(); ?>">Редактировать</a> |
                <a href="delete_equipment.php?id=<?php echo $equipment->getId(); ?>">Удалить</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Добавить новое оборудование</h3>
<form method="post" action="equipment_list.php">
    <label for="name">Название:</label>
    <input type="text" name="name" id="name" required>
    <br>
    <label for="code">Код:</label>
    <input type="text" name="code" id="code" required>
    <br>
    <button type="submit">Добавить</button>
</form>

<p><a href="../index.php">Вернуться на главную</a></p> <!-- Исправленный путь -->

</body>
</html>
