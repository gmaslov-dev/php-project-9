<?php

namespace Hexlet\Code\Config;

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use Slim\Views\Twig;
use Twig\Error\LoaderError;

class AppConfig
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
            throw new \RuntimeException('DATABASE_URL not set');
        }

        $components = parse_url($databaseUrl);
        $host = $components['host'];
        $user = $components['user'];
        $pass = $components['pass'];
        $dbName = ltrim($components['path'], '/');


        $dsn = "pgsql:host=$host;port=5432;dbname=$dbName;sslmode=require";

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
