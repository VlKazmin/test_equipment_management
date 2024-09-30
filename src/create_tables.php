<?php

require_once __DIR__ . '/../config/db.php';

$connection = getConnection();

try {
    // Создание таблицы employees
    $sql = "
        CREATE TABLE IF NOT EXISTS employees (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(255) NOT NULL,
            inn VARCHAR(12) NOT NULL,
            phone_number VARCHAR(15),
            email VARCHAR(255),
            position VARCHAR(100),
            department VARCHAR(100)
        );
    ";
    $connection->exec($sql);

    // Создание таблицы equipment
    $sql = "
        CREATE TABLE IF NOT EXISTS equipment (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            code VARCHAR(50) NOT NULL
        );
    ";
    $connection->exec($sql);

    // Создание таблицы equipment_usage
    $sql = "
        CREATE TABLE IF NOT EXISTS equipment_usage (
            id INT AUTO_INCREMENT PRIMARY KEY,
            equipment_id INT NOT NULL,
            inventory_number VARCHAR(25) NOT NULL,
            status ENUM('в использовании', 'на складе') NOT NULL DEFAULT 'на складе',
            employee_id INT,
            issue_date DATE,
            return_date DATE NULL,
            FOREIGN KEY (employee_id) REFERENCES employees(id),
            FOREIGN KEY (equipment_id) REFERENCES equipment(id)
        );
    ";
    $connection->exec($sql);

    $sql = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
        );
    ";
    $connection->exec($sql);

    // Добавим пользователя admin
    $sql = "
    INSERT INTO users (username, password)
    VALUES ('admin', SHA2('admin', 256));";
    $connection->exec($sql);

    echo "Таблицы успешно созданы!";
} catch (PDOException $e) {
    die("Ошибка при создании таблиц: " . $e->getMessage());
}
