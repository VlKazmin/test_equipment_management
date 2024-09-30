<?php

namespace App\Models;

/**
 * Class Equipment
 *
 * Модель для представления оборудования в системе.
 */
class Equipment
{
    private ?int $id;
    private string $name;
    private string $code;

    /**
     * Equpmient constructor.
     *
     * @param string $name название оборудования.
     * @param string $code код оборудования.
     */
    public function __construct($id, $name, $code)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
    }

    /**
         * Получить идентификатор оборудования.
         *
         * @return int Идентификатор оборудования.
         */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Получить название оборудования.
     *
     * @return string Название оборудования.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Получить название оборудования.
     *
     * @return string Название оборудования.
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Установить название оборудования.
     *
     * @param string $name Название оборудования.
     *
     * @throws \InvalidArgumentException Если имя пустое.
     */
    public function setName(string $name): void
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("Поле не может быть пустым.");
        }
        $this->name = $name;
    }

    /**
     * Получить код оборудования.
     *
     * @return string Код оборудования.
     */
    public function getEquipmentCode(): string
    {
        return $this->code;
    }

    /**
     * Установить код оборудования.
     *
     * @param string $code Код оборудования.
     *
     * @throws \InvalidArgumentException Если код пустой.
     */
    public function setEquipmentCode(string $code): void
    {
        if (empty($code)) {
            throw new \InvalidArgumentException('Код оборудования не может быть пустым.');
        }
        $this->code = $code;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}
