<?php

namespace Hexlet\Code\Repository;

use Hexlet\Code\Database\Connection;
use Hexlet\Code\Entity\Url;
use PDO;

class UrlRepository
{
    private PDO $pdo;

    public function __construct(Connection $connection)
    {
        $this->pdo = $connection->connect();
    }

    public function getAll(): array
    {
        $urls = [];
        $sql = "SELECT * FROM urls ORDER BY created_at DESC";
        $stmt = $this->pdo->query($sql);
        if ($stmt === false) {
            return [];
        }
        while ($row = $stmt->fetch()) {
            $url = Url::fromArray([
                'name' => $row['name'],
                'created_at' => $row['created_at']
            ]);
            $url->setId($row['id']);
            $urls[] = $url;
        }

        return $urls;
    }

    public function findById(int $id): ?Url
    {
        $sql = "SELECT * FROM urls WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        if ($row = $stmt->fetch()) {
            $url = Url::fromArray([
                'name' => $row['name'],
                'created_at' => $row['created_at']
            ]);

            $url->setId($row['id']);
            return $url;
        }
        return null;
    }

    public function findByName(string $name): ?Url
    {
        $sql = "SELECT * FROM urls WHERE name = :name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name]);
        if ($row = $stmt->fetch()) {
            $url = Url::fromArray([
                'name' => $row['name'],
                'created_at' => $row['created_at']
            ]);

            $url->setId($row['id']);
            return $url;
        }
        return null;
    }

    public function save(Url $url): void
    {
        if ($url->exists()) {
            $this->update($url);
        } else {
            $this->create($url);
        }
    }

    public function update(Url $url): void
    {
        $sql = "UPDATE urls SET name = :name, created_at = :created_at WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $id = $url->getId();
        $name = $url->getName();
        $createdAt = $url->getCreatedAt();

        $stmt->execute([
            'name' => $name,
            'created_at' => $createdAt,
            'id' => $id
        ]);
    }

    public function create(Url $url): void
    {
        $sql = "INSERT INTO urls (name, created_at) VALUES (:name, :created_at)";
        $stmt = $this->pdo->prepare($sql);
        $name = $url->getName();
        $createdAt = $url->getCreatedAt();
        $stmt->execute([
            'name' => $name,
            'created_at' => $createdAt
        ]);
        $id = (int) $this->pdo->lastInsertId();
        $url->setId($id);
    }
}
