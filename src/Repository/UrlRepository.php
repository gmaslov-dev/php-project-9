<?php

namespace Hexlet\Code\Repository;

use Hexlet\Code\Entity\Url;
use PDO;

class UrlRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Url $url): void
    {
        $sql = "INSERT INTO urls (name, created_at) VALUES (:name, :created_at) RETURNING id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'name' => $url->getName(),
            'created_at' => $url->getCreatedAt(),
        ]);
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM urls";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => new Url($row['id'], $row['name'], $row['created_at']), $rows);
    }
}