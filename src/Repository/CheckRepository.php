<?php

namespace Hexlet\Code\Repository;

use Hexlet\Code\Entity\Check;
use PDO;

class CheckRepository
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function save(Check $check): int
    {
        $sql = "INSERT INTO checks (url_id, status_code, h1, title, description, created_at) VALUES (:url_id, :status_code, :h1, :title, :description, :created_at)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'url_id' => $check->getUrlId(),
            'status_code' => $check->getStatusCode(),
            'h1' => $check->getH1(),
            'title' => $check->getTitle(),
            'description' => $check->getDescription(),
            'created_at' => $check->getCreatedAt(),
        ]);

        $id = (int) $this->conn->lastInsertId();
        $check->setId($id);

        return $id;
    }

    public function findByUrlId(int $urlId): array
    {
        $sql = "SELECT * FROM checks WHERE url_id = :url_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$urlId]);
        $rows = $stmt->fetchAll();


        return array_map(function ($row) {
            return Check::fromArray([
                'url_id' => $row['url_id'],
                'created_at' => $row['created_at'],
                'id' => $row['id'],
                'status_code' => $row['status_code'],
                'h1' => $row['h1'],
                'title' => $row['title'],
                'description' => $row['description'],
            ]);
        }, $rows);
    }

    public function findLastByUrlId($urlId)
    {
        $sql = "SELECT * FROM checks WHERE url_id = :url_id ORDER BY created_at DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$urlId]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return Check::fromArray([
            'url_id' => $row['url_id'],
            'created_at' => $row['created_at'],
            'id' => $row['id'],
            'status_code' => $row['status_code'],
            'h1' => $row['h1'],
            'title' => $row['title'],
            'description' => $row['description'],
        ]);
    }
}
