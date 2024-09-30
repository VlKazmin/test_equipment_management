<?php

namespace App\Repositories;

use PDO;
use App\Models\Equipment;

/**
 * Репозиторий для работы с оборудованием.
 */
class EquipmentRepository
{
    private PDO $connection;

    /**
     * Конструктор, устанавливающий соединение с базой данных.
     *
     * @param PDO $connection Подключение к базе данных.
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Добавить новое оборудование в базу данных.
     *
     * @param Equipment $equipment Объект Equipment.
     * @return bool Возвращает true в случае успешного добавления.
     */
    public function addEquipment(Equipment $equipment): bool
    {
        try {
            $sql = "INSERT INTO equipment (name, code) VALUES (:name, :code)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':name', $equipment->getName());
            $stmt->bindParam(':code', $equipment->getCode());

            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Ошибка добавления оборудования: " . $e->getMessage());
        }
    }

    /**
     * Получить оборудование по идентификатору.
     *
     * @param int $id Идентификатор оборудования.
     * @return Equipment|null Объект Equipment или null.
     */
    public function getEquipmentById(int $id): ?Equipment
    {
        $stmt = $this->connection->prepare("SELECT * FROM equipment WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();

        if ($row) {
            return new Equipment($row['id'], $row['name'], $row['code']);
        }

        return null;
    }

    /**
     * Обновить данные оборудования.
     */
    public function updateEquipment(
        int $id,
        string $name,
        string $code
    ): bool {
        $sql = "UPDATE equipment
                SET name = :name,
                    code = :code
                WHERE id = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":code", $code);

        return $stmt->execute();
    }

    /**
     * Удалить оборудование по его идентификатору.
     *
     * @param int $id Идентификатор оборудования.
     * @return bool Возвращает true в случае успешного удаления.
     */
    public function deleteEquipment(int $id): bool
    {
        $sql = "DELETE FROM equipment WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Получить всё оборудование.
     *
     * @return Equipment[] Список объектов Equipment.
     */
    public function getAllEquipments(): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM equipment");
        $stmt->execute();
        $results = $stmt->fetchAll();

        $equipments = [];
        foreach ($results as $row) {
            $equipments[] = new Equipment($row['id'], $row['name'], $row['code']);
        }

        return $equipments;
    }
}
