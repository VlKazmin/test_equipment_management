<?php

function getConnection(): \PDO
{

    $host = 'localhost';
    $dbname = 'equipment_management';
    $user = 'root';
    $password = '8251';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $options = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new \PDO($dsn, $user, $password, $options);
        return $pdo;
    } catch (\PDOException $e) {
        die('Ошибка подключения: ' . $e->getMessage());
    }
}
