<?php

namespace Hexlet\Code\Database;

use Dotenv\Dotenv;
use PDO;

final class Connection
{
    private static ?self $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        dump($dotenv);
        $dotenv->load();

        $databaseUrl = parse_url($_ENV['DATABASE_URL']);
        $username = $databaseUrl['user']; // janedoe
        $password = $databaseUrl['pass']; // mypassword
        $host = $databaseUrl['host']; // localhost
        $port = $databaseUrl['port']; // 5432
        $dbName = ltrim($databaseUrl['path'], '/'); // mydb

        $dsn = "pgsql:host={$host};dbname={$dbName};port={$port}";
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
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
}
