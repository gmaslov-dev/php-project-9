<?php

namespace Hexlet\Code\Database;

use PDO;

final class Connection
{
    private PDO $pdo;

    public function __construct(array $data)
    {
        $this->pdo = new PDO($data['dsn'], $data['user'], $data['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function connect(): PDO
    {
        return $this->pdo;
    }
}
