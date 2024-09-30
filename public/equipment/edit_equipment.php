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

// Получение идентификатора оборудования из URL
$id = $_GET['id'] ?? null;

if ($id === null) {
    header('Location: equipment_list.php');
    exit();
}

// Получение оборудования по идентификатору
$equipment = $equipmentRepository->getEquipmentById((int)$id);

if ($equipment === null) {
    header('Location: equipment_list.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $code = $_POST['code'] ?? '';

    if (!empty($name) && !empty($code)) {
        $equipmentRepository->updateEquipment($id, $name, $code);
        header('Location: equipment_list.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать оборудование</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Редактировать оборудование</h2>

<form method="post" action="edit_equipment.php?id=<?php echo $equipment->getId(); ?>">
    <label for="name">Название:</label>
    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($equipment->getName()); ?>" required>
    <br>
    <label for="code">Код:</label>
    <input type="text" name="code" id="code" value="<?php echo htmlspecialchars($equipment->getCode()); ?>" required>
    <br>
    <button type="submit">Сохранить изменения</button>
</form>

<p><a href="equipment_list.php">Вернуться к перечню оборудования</a></p>

</body>
</html>
