<?php

namespace Hexlet\Code\Database;

use Dotenv\Dotenv;
use PDO;

final class Connection
{
    private static ?self $conn = null;

    public function connect(): PDO
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

        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }


    public static function get(): self
    {
        if (self::$conn === null) {
            self::$conn = new self();
        }

        return self::$conn;
    }

    protected function __construct()
    {
    }
}
