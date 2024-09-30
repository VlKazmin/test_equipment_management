<?php

namespace App\Repositories;

use PDO;
use App\Models\EquipmentUsage;

/**
 * Репозиторий для работы с записями использования оборудования.
 */
class EquipmentUsageRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Проверить, находится ли оборудование в использовании.
     */
    private function isEquipmentInUse(int $equipment_id): bool
    {
        $sql = "SELECT COUNT(*) as count
            FROM equipment_usage
            WHERE equipment_id = :equipment_id
            AND status = 'в использовании'";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':equipment_id', $equipment_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    /**
     * Добавить запись о использовании оборудования.
     */
    public function addEquipmentUsage(EquipmentUsage $equipmentUsage): bool
    {
        if ($this->isEquipmentInUse($equipmentUsage->getEquipmentId())) {
            return false;
        }

        $sql = "INSERT INTO equipment_usage (
                employee_id,
                equipment_id,
                inventory_number,
                issue_date,
                status
            ) VALUES (
                :employee_id,
                :equipment_id,
                :inventory_number,
                :issue_date,
                :status
            )";

        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':employee_id', $equipmentUsage->getEmployeeId(), PDO::PARAM_INT);
        $stmt->bindParam(':equipment_id', $equipmentUsage->getEquipmentId(), PDO::PARAM_INT);
        $stmt->bindParam(':inventory_number', $equipmentUsage->getInventoryNumber());
        $stmt->bindParam(':issue_date', $equipmentUsage->getIssueDate());
        $stmt->bindParam(':status', $equipmentUsage->getStatus());

        return $stmt->execute();
    }

    /**
     * Получить запись об использовании оборудования по идентификатору.
     */
    public function getEquipmentUsageById(int $id): ?array
    {
        $sql = "SELECT * FROM equipment_usage WHERE id = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Обновить запись об использовании оборудования.
     */
    public function updateEquipmentUsage(
        int $id,
        int $employee_id,
        int $equipment_id,
        string $inventory_number,
        string $issue_date,
        ?string $return_date = null,
        string $status = 'в использовании'
    ): bool {
        $sql = "UPDATE equipment_usage
                SET employee_id = :employee_id,
                    equipment_id = :equipment_id,
                    inventory_number = :inventory_number,
                    issue_date = :issue_date,
                    return_date = :return_date,
                    status = :status
                WHERE id = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->bindParam(':equipment_id', $equipment_id);
        $stmt->bindParam(':inventory_number', $inventory_number);
        $stmt->bindParam(':issue_date', $issue_date);
        $stmt->bindParam(':return_date', $return_date);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Перевести оборудование на склад.
     */
    public function transferToStorage(int $id, string $return_date): bool
    {
        $usageRecord = $this->getEquipmentUsageById($id);

        if ($usageRecord) {
            $sql = "UPDATE equipment_usage
                    SET status = 'на складе',
                        return_date = :return_date,
                        employee_id = NULL,
                        issue_date = NULL
                    WHERE id = :id";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':return_date', $return_date);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        }

        return false; // Если запись не найдена
    }

    /**
     * Удалить запись об использовании оборудования.
     */
    public function deleteEquipmentUsage(int $id): bool
    {
        $sql = "DELETE FROM equipment_usage WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Получить все записи использования оборудования.
     */
    public function getAllEquipmentUsages(): array
    {
        $sql = "SELECT
                    e.id AS id,
                    e.inventory_number,
                    e.issue_date,
                    e.status,
                    e.return_date,
                    eq.name AS equipment_name,
                    em.full_name AS employee_full_name
                FROM
                    equipment_usage e
                LEFT JOIN
                    equipment eq ON e.equipment_id = eq.id
                LEFT JOIN
                    employees em ON e.employee_id = em.id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($equipmentUsageId, $status)
    {
        $stmt = $this->connection->prepare("
            UPDATE equipment_usage
            SET status = ?, return_date = NOW()
            WHERE id = ?
        ");
        $stmt->execute([$status, $equipmentUsageId]);
    }
}
