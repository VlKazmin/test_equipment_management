<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Repositories/EquipmentRepository.php';

use App\Repositories\EquipmentRepository;

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$connection = getConnection();
$equipmentRepository = new EquipmentRepository($connection);

$id = $_GET['id'] ?? null;

if ($id === null) {
    header('Location: equipment_list.php');
    exit();
}

$equipment = $equipmentRepository->getEquipmentById((int)$id);

if ($equipment === null) {
    header('Location: equipment_list.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipmentRepository->deleteEquipment($id);
    header('Location: equipment_list.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Удалить оборудование</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Удалить оборудование</h2>

<p>Вы уверены, что хотите удалить оборудование "<?php echo htmlspecialchars($equipment->getName()); ?>"?</p>

<form method="post" action="delete_equipment.php?id=<?php echo $equipment->getId(); ?>">
    <button type="submit">Удалить</button>
    <a href="equipment_list.php">Отмена</a>
</form>

</body>
</html>
