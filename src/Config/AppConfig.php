<?php

namespace Hexlet\Code\Config;

use GuzzleHttp\Client;
use Slim\Views\Twig;
use Twig\Error\LoaderError;

class AppConfig
{
    public function getDsn(): array
    {
        $databaseUrl = getenv('DATABASE_URL');

        if (!$databaseUrl) {
            $databaseUrl = $_ENV['DATABASE_URL'];
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
