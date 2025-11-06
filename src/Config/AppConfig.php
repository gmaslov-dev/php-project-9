<?php

namespace Hexlet\Code\Config;

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use RuntimeException;
use Slim\Views\Twig;
use Twig\Error\LoaderError;

readonly class AppConfig
{
    public function getDsn(): array
    {
        $databaseUrl = getenv('DATABASE_URL') ?: ($_ENV['DATABASE_URL'] ?? null);

        if (!$databaseUrl && file_exists(__DIR__ . '/../../.env')) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->safeLoad(); // безопасная загрузка
            $databaseUrl = getenv('DATABASE_URL') ?: ($_ENV['DATABASE_URL'] ?? null);
        }

        if (!$databaseUrl) {
            throw new RuntimeException('DATABASE_URL not set');
        }

        $components = parse_url($databaseUrl);

        if ($components === false) {
            throw new RuntimeException("Invalid DATABASE_URL: $databaseUrl");
        }

        $host = $components['host'] ?? null;
        $user = $components['user'] ?? null;
        $pass = $components['pass'] ?? null;
        $dbName = ltrim($components['path']  ?? null, '/');


        $dsn = "pgsql:host=$host;port=5432;dbname=$dbName;";

        return [
            'dsn' => $dsn,
            'user' => $user,
            'pass' => $pass
        ];
    }

    /**
     * @throws LoaderError
     */
    public function createTwig(): Twig
    {
        return Twig::create(__DIR__ . '/../../templates', ['cache' => false, 'debug' => true]);
    }

    public function createClient(): Client
    {
        return new Client([
            'timeout' => 5,
            'verify' => true,
            'http_errors' => false,
            'allow_redirects' => true
        ]);
    }
}
