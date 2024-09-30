<?php

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Repositories/EquipmentUsageRepository.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$connection = getConnection();
$equipmentUsageRepository = new \App\Repositories\EquipmentUsageRepository($connection);

$equipmentUsageId = $_GET['id'] ?? null;

if ($equipmentUsageId) {
    $equipmentUsageRepository->deleteEquipmentUsage($equipmentUsageId);
}

header('Location: equipment_usage.php');
exit();
