<?php

namespace App\Models;

/**
 * Класс EquipmentUsage
 *
 * Модель для представления использования оборудования сотрудниками.
 */
class EquipmentUsage
{
    private int $id;
    private int $employeeId;
    private int $equipmentId;
    private string $inventoryNumber;
    private string $issueDate;
    private string $status = 'в использовании';

    private $employee;
    private $equipment;

    /**
     * EquipmentUsage constructor.
     *
     * @param int $employeeId Идентификатор сотрудника.
     * @param int $equipmentId Идентификатор оборудования.
     * @param string $inventoryNumber Инвентарный номер оборудования.
     * @param string $issueDate Дата выдачи оборудования.
     */
    public function __construct(
        int $employeeId,
        int $equipmentId,
        string $inventoryNumber,
        string $issueDate
    ) {
        $this->employeeId = $employeeId;
        $this->equipmentId = $equipmentId;
        $this->inventoryNumber = $inventoryNumber;
        $this->issueDate = $issueDate;
    }

    /**
     * Получить идентификатор записи.
     *
     * @return int Идентификатор записи.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Получить идентификатор сотрудника.
     *
     * @return int Идентификатор сотрудника.
     */
    public function getEmployeeId(): int
    {
        return $this->employeeId;
    }

    /**
     * Получить идентификатор оборудования.
     *
     * @return int Идентификатор оборудования.
     */
    public function getEquipmentId(): int
    {
        return $this->equipmentId;
    }

    /**
     * Получить инвентарный номер оборудования.
     *
     * @return string Инвентарный номер оборудования.
     */
    public function getInventoryNumber(): string
    {
        return $this->inventoryNumber;
    }

    /**
     * Получить дату выдачи оборудования.
     *
     * @return string Дата выдачи оборудования.
     */
    public function getIssueDate(): string
    {
        return $this->issueDate;
    }

    /**
     * Получить статус использования оборудования.
     *
     * @return string Статус использования (всегда 'в использовании').
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    public function setEmployee($employee): void
    {
        $this->employee = $employee;
    }

    public function getEmployee()
    {
        return $this->employee;
    }

    public function setEquipment($equipment): void
    {
        $this->equipment = $equipment;
    }

    public function getEquipment()
    {
        return $this->equipment;
    }
}
