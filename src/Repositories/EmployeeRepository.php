<?php

namespace App\Repositories;

use PDO;
use App\Models\Employee;

/**
 * Репозиторий для работы с сотрудниками.
 */
class EmployeeRepository
{
    private \PDO $connection;

    /**
     * Конструктор, устанавливающий соединение с базой данных.
     *
     * @param PDO $connection Подключение к базе данных.
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Добавить нового сотрудника в базу данных.
     *
     * @param string $fullName Полное имя сотрудника.
     * @param string $inn ИНН сотрудника.
     * @param string $phoneNumber Номер телефона.
     * @param string $email Электронная почта.
     * @param string $position Должность.
     * @param string $department Отдел.
     * @return bool Возвращает true в случае успешного добавления.
     */
    public function addEmployee(Employee $employee): bool
    {
        $sql = "INSERT INTO employees (full_name, inn, phone_number, email, position, department)
                VALUES (:full_name, :inn, :phone_number, :email, :position, :department)";

        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':full_name', $employee->getFullName());
        $stmt->bindParam(':inn', $employee->getInn());
        $stmt->bindParam(':phone_number', $employee->getPhoneNumber());
        $stmt->bindParam(':email', $employee->getEmail());
        $stmt->bindParam(':position', $employee->getPosition());
        $stmt->bindParam(':department', $employee->getDepartment());

        return $stmt->execute();
    }

    /**
     * Получить сотрудника по его идентификатору.
     *
     * @param int $id Идентификатор сотрудника.
     * @return array|null Данные сотрудника или null, если сотрудник не найден.
     */
    public function getEmployeeById(int $id): ?array
    {
        $sql = "SELECT * FROM employees WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Обновить данные сотрудника.
     *
     * @param int $id Идентификатор сотрудника.
     * @param string $fullName Полное имя.
     * @param string $inn ИНН.
     * @param string $phoneNumber Номер телефона.
     * @param string $email Электронная почта.
     * @param string $position Должность.
     * @param string $department Отдел.
     * @return bool Возвращает true в случае успешного обновления.
     */
    public function updateEmployee(
        int $id,
        string $fullName,
        string $inn,
        string $phoneNumber,
        string $email,
        string $position,
        string $department
    ): bool {
        $sql = "UPDATE employees
                SET full_name = :full_name,
                    inn = :inn,
                    phone_number = :phone_number,
                    email = :email,
                    position = :position,
                    department = :department
                WHERE id = :id";

        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':full_name', $fullName);
        $stmt->bindParam(':inn', $inn);
        $stmt->bindParam(':phone_number', $phoneNumber);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':department', $department);

        return $stmt->execute();
    }

    /**
     * Удалить сотрудника по его идентификатору.
     *
     * @param int $id Идентификатор сотрудника.
     * @return bool Возвращает true в случае успешного удаления.
     */
    public function deleteEmployee(int $id): bool
    {
        $sql = "DELETE FROM employees WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Получить всех сотрудников.
     *
     * @return array Список сотрудников.
     */
    public function getAllEmployees(): array
    {
        $sql = "SELECT * FROM employees";
        $stmt = $this->connection->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
