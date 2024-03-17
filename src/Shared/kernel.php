<?php

declare(strict_types = 1);

use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Source\Shared\DependencyInjector;
use Source\Shared\MysqlClient\MysqlClient;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
    $dotenv->load();

    MysqlClient::connect($_ENV['MYSQL_HOST'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASS'], (int)$_ENV['MYSQL_PORT']);
    MysqlClient::selectDatabase($_ENV['MYSQL_DB']);

    $dependencyInjector = new DependencyInjector();
    $dependencies = require dirname(__DIR__, 2) . '/configuration/dependencies.php';
    $dependencyInjector->addDependencies($dependencies);

    $containerBuilder = new ContainerBuilder();
    $containerBuilder->addDefinitions($dependencyInjector->get());

    AppFactory::setContainer($containerBuilder->build());
    $app = AppFactory::create();

    $app->addRoutingMiddleware();
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    $app->add(function (ServerRequestInterface $request, RequestHandlerInterface $requestHandler) {
        $response = $requestHandler->handle($request);
        $response->withHeader('Content-Type', 'application/json');
        $response->withStatus(404);
        return $response;
    });

    require dirname(__DIR__, 2) . '/configuration/routes.php';

    $app->run();
} catch (Exception $e) {
    echo sprintf('Error %d: %s', $e->getCode(), $e->getMessage());
}
