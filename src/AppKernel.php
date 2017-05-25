<?php
declare(strict_types=1);

namespace Nastoletni\Code;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Nastoletni\Code\Application\PasteMapper;
use Nastoletni\Code\Infrastructure\Dbal\DbalPasteRepository;
use Nastoletni\Code\Slim\DecoratingCallableResolver;
use Nastoletni\Code\UserInterface\Controller\ControllerDecorator;
use Nastoletni\Code\UserInterface\Web\Controller\PasteController;
use Slim\App;
use Slim\Container;
use Slim\Handlers\Error;
use Slim\Handlers\PhpError;
use Slim\Handlers\Strategies\RequestResponseArgs;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Symfony\Component\Yaml\Yaml;

class AppKernel
{
    /**
     * @var App
     */
    private $slim;

    /**
     * AppKernel constructor.
     */
    public function __construct()
    {
        $this->slim = new App();

        $this->setupConfig();

        $container = $this->slim->getContainer();
        $container['settings']['displayErrorDetails'] = $container['config']['debug'];
        $container['logger'] = function () {
            return new Logger('application', [
                new StreamHandler(__DIR__.'/../logs.log')
            ]);
        };
        $container['foundHandler'] = function () {
            return new RequestResponseArgs();
        };
        $container['errorHandler'] = function (Container $container) {
            return new Slim\Handler\LoggingErrorHandler(
                $container->get('logger'),
                new Error($container['config']['debug'])
            );
        };
        $container['phpErrorHandler'] = function (Container $container) {
            return new Slim\Handler\LoggingErrorHandler(
                $container->get('logger'),
                new PhpError($container['config']['debug'])
            );
        };
        $container['twig'] = function (Container $container) {
            $twig = new Twig(__DIR__.'/../resources/views/', [
                'debug' => $container['config']['debug']
            ]);
            $twig->addExtension(new TwigExtension($container['router'], $container['config']['base_url']));

            return $twig;
        };
        $container['callableResolver'] = function (Container $container) {
            return new DecoratingCallableResolver(
                $container,
                new ControllerDecorator(
                    $container['twig'],
                    $container['router']
                )
            );
        };

        $container['dbal'] = function (Container $container) {
            $config = new Configuration();

            return DriverManager::getConnection([
                'driver' => 'pdo_mysql',
                'host' => $container['config']['database']['host'],
                'dbname' => $container['config']['database']['name'],
                'user' => $container['config']['database']['user'],
                'password' => $container['config']['database']['password'],
                'charset' => $container['config']['database']['charset'],
            ], $config);
        };
        $container[PasteController::class] = function (Container $container) {
            $pasteRepository = new DbalPasteRepository($container['dbal'], new PasteMapper());

            return new PasteController($pasteRepository);
        };

        $this->setupRoutes();
    }

    /**
     * Sets up config in container.
     */
    private function setupConfig(): void
    {
        $config = Yaml::parse(file_get_contents(__DIR__.'/config.yml'));

        $this->slim->getContainer()['config'] = $config;
    }

    /**
     * Sets up routes.
     */
    private function setupRoutes(): void
    {
        $routes = Yaml::parse(file_get_contents(__DIR__.'/routes.yml'));

        foreach ($routes as $routeName => $route) {
            $this->slim->map([$route['method']], $route['path'], $route['controller'])->setName($routeName);
        }
    }

    /**
     * Sends response to the client.
     */
    public function handle(): void
    {
        $this->slim->run();
    }
}
