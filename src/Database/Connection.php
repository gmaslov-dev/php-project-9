<?php

namespace Hexlet\Code\Database;

use Dotenv\Dotenv;
use PDO;
use PDOException;

final class Connection
{
    private static ?self $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $databaseUrl = parse_url($_ENV['DATABASE_URL']);
        $username = $databaseUrl['user'];
        $password = $databaseUrl['pass'];
        $host = $databaseUrl['host'];
        $port = $databaseUrl['port'];
        $dbName = ltrim($databaseUrl['path'], '/');

        $dsn = "pgsql:host={$host};dbname={$dbName};port={$port}";
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

        $this->dbInit();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    private function dbInit()
    {
        $sqlFile = __DIR__ . '/../../database.sql';
        try {
            $pdo = $this->getConnection();
            $sql = file_get_contents($sqlFile);
            $pdo->exec($sql);
        } catch (PDOException $e) {
            echo "Ошибка выполнения SQL: " . $e->getMessage();
        }
    }
}
