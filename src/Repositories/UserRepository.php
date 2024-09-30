<?php

namespace App\Repositories;

use PDO;
use App\Models\User;

class UserRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getUserByUsername(string $username): ?User
    {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return new User($user['id'], $user['username'], $user['password']);
        }

        return null;
    }
}
