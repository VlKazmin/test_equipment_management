<?php

namespace App\Models;

/**
 * Class Employee
 *
 * Модель для представления сотрудника в системе.
 */
class Employee
{
    private int $id;
    private string $full_name;
    private string $inn;
    private string $phone_number;
    private string $email;
    private string $position;
    private string $department;

    /**
     * Employee constructor.
     *
     * @param string $full_name Полное имя сотрудника
     * @param string $inn ИНН сотрудника
     * @param string $phone_number Номер телефона
     * @param string $email Электронная почта
     * @param string $position Должность
     * @param string $department Отдел
     *
     * @throws \InvalidArgumentException Если данные некорректны
     */
    public function __construct(
        string $full_name,
        string $inn,
        string $phone_number,
        string $email,
        string $position,
        string $department
    ) {
        $this->setFullName($full_name);
        $this->setInn($inn);
        $this->setPhoneNumber($phone_number);
        $this->setEmail($email);
        $this->position = $position;
        $this->department = $department;
    }

    /**
     * Получить полное имя сотрудника.
     *
     * @return string Полное имя
     */
    public function getFullName(): string
    {
        return $this->full_name;
    }

    /**
     * Установить полное имя сотрудника.
     *
     * @param string $full_name Полное имя
     *
     * @throws \InvalidArgumentException Если имя пустое
     */
    public function setFullName(string $full_name): void
    {
        if (empty($full_name)) {
            throw new \InvalidArgumentException('Полное имя не может быть пустым.');
        }
        $this->full_name = $full_name;
    }

    /**
     * Получить ИНН сотрудника.
     *
     * @return string ИНН
     */
    public function getInn(): string
    {
        return $this->inn;
    }

    /**
     * Установить ИНН сотрудника.
     *
     * @param string $inn ИНН
     *
     * @throws \InvalidArgumentException Если ИНН не соответствует формату
     */
    public function setInn(string $inn): void
    {
        if (!preg_match('/^\d{10}$/', $inn)) {
            throw new \InvalidArgumentException('ИНН должен состоять из 10 цифр.');
        }
        $this->inn = $inn;
    }

    /**
     * Получить номер телефона сотрудника.
     *
     * @return string Номер телефона
     */
    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    /**
     * Установить номер телефона сотрудника.
     *
     * @param string $phone_number Номер телефона
     *
     * @throws \InvalidArgumentException Если номер телефона некорректен
     */
    public function setPhoneNumber(string $phone_number): void
    {
        if (!preg_match('/^\+?\d{10,15}$/', $phone_number)) {
            throw new \InvalidArgumentException('Некорректный номер телефона.');
        }
        $this->phone_number = $phone_number;
    }

    /**
     * Получить электронную почту сотрудника.
     *
     * @return string Электронная почта
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Установить электронную почту сотрудника.
     *
     * @param string $email Электронная почта
     *
     * @throws \InvalidArgumentException Если email некорректен
     */
    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Некорректный email.');
        }
        $this->email = $email;
    }

    /**
     * Получить должность сотрудника.
     *
     * @return string Должность
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * Получить отдел сотрудника.
     *
     * @return string Отдел
     */
    public function getDepartment(): string
    {
        return $this->department;
    }

    /**
     * Получить идентификатор сотрудника.
     *
     * @return int Идентификатор сотрудника
     */
    public function getId(): int
    {
        return $this->id;
    }
}
