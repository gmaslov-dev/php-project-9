<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Psr\Container\ContainerInterface;
use Slim\App;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Factory\ServerRequestFactory;

class TestCase extends PHPUnitTestCase
{
    protected App $app;
    protected ?ContainerInterface $container = null;

    public function setUp(): void
    {
        $this->app = require __DIR__ . '/../bootstrap/app.php';
        $this->container = $this->app->getContainer();

        // TODO: настройка тестовой БД
        // $this->setUpDatabase();
    }

    protected function createRequest(
        string $method,
        string $uri,
        array $data = [],
        array $headers = []
    ): ResponseInterface {
        $serverRequestFactory = new ServerRequestFactory();
        $request = $serverRequestFactory->createServerRequest($method, $uri);

        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        if (!empty($data)) {
            $request = $request->withParsedBody($data);
        }

        return $this->app->handle($request);
    }
}
