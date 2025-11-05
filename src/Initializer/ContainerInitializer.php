<?php

namespace Hexlet\Code\Initializer;

use DI\Container;
use DI\ContainerBuilder;
use GuzzleHttp\Client;
use Hexlet\Code\Config\AppConfig;
use Hexlet\Code\Database\Connection;
use Hexlet\Code\Handler\ErrorHandler;
use Hexlet\Code\Repository\CheckRepository;
use Hexlet\Code\Repository\UrlRepository;
use Hexlet\Code\Service\CheckService;
use Hexlet\Code\Service\UrlCheckerService;
use Hexlet\Code\Service\UrlCheckService;
use Slim\Flash\Messages;
use Slim\Views\Twig;

use function DI\autowire;
use function DI\factory;

readonly class ContainerInitializer
{
    /**
     * @throws \Exception
     */
    public static function init(): Container
    {
        $builder = new ContainerBuilder();

        $builder->addDefinitions([
            AppConfig::class => autowire(),

            Connection::class => factory(fn(AppConfig $config) => new Connection($config->getDsn())),
            Twig::class => factory(fn(AppConfig $config) => $config->createTwig()),
            Client::class => factory(fn(AppConfig $config) => $config->createClient()),

            UrlRepository::class => autowire(),
            CheckRepository::class => autowire(),
            CheckService::class => autowire(),
            UrlCheckService::class => autowire(),
            UrlCheckerService::class => autowire(),

            Messages::class => autowire(),
            ErrorHandler::class => autowire()
        ]);

        return $builder->build();
    }
}
