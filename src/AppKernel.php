<?php

declare(strict_types=1);

namespace Nastoletni\Code;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Nastoletni\Code\Infrastructure\AES256Crypter;
use Nastoletni\Code\Infrastructure\Dbal\DbalPasteMapper;
use Nastoletni\Code\Infrastructure\Dbal\DbalPasteRepository;
use Nastoletni\Code\Infrastructure\HttpsXkcdRepository;
use Nastoletni\Code\Slim\DecoratingCallableResolver;
use Nastoletni\Code\Slim\Middleware\SymfonySessionMiddleware;
use Nastoletni\Code\Twig\SymfonyValidatorExtension;
use Nastoletni\Code\UserInterface\Controller\ControllerDecorator;
use Nastoletni\Code\UserInterface\Web\Controller\ErrorController;
use Nastoletni\Code\UserInterface\Web\Controller\PasteController;
use Slim\App;
use Slim\Container;
use Slim\Handlers\Error;
use Slim\Handlers\PhpError;
use Slim\Handlers\Strategies\RequestResponseArgs;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Symfony\Component\HttpFoundation\Session\Session;
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
        $this->setupServices();
        $this->setupRoutes();

        // Middlewares
        $this->slim->add(new SymfonySessionMiddleware($this->slim->getContainer()['session']));
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
     * Sets up dependencies in container.
     */
    private function setupServices(): void
    {
        $container = $this->slim->getContainer();
        $container['settings']['displayErrorDetails'] = $container['config']['debug'];
        $container['logger'] = function () {
            return new Logger('application', [
                new StreamHandler(__DIR__.'/../logs/logs.log'),
            ]);
        };
        $container['foundHandler'] = function () {
            return new RequestResponseArgs();
        };
        $container['notFoundHandler'] = function (Container $container) {
            return [$container[ErrorController::class], 'notFound'];
        };
        $container['errorHandler'] = function (Container $container) {
            // Show pretty error page on production and Slim debug info on development.
            $next = $container['config']['debug'] ?
                new Error($container['config']['debug']) :
                [$container[ErrorController::class], 'error'];

            return new Slim\Handler\LoggingErrorHandler(
                $container->get('logger'),
                $next
            );
        };
        $container['phpErrorHandler'] = function (Container $container) {
            // Show pretty error page on production and Slim debug info on development.
            $next = $container['config']['debug'] ?
                new PhpError($container['config']['debug']) :
                [$container[ErrorController::class], 'error'];

            return new Slim\Handler\LoggingErrorHandler(
                $container->get('logger'),
                $next
            );
        };
        $container['twig'] = function (Container $container) {
            $twig = new Twig(__DIR__.'/../resources/views/', [
                'debug' => $container['config']['debug'],
            ]);
            $twig->addExtension(new TwigExtension($container['router'], $container['config']['base_url']));
            $twig->addExtension(new SymfonyValidatorExtension());

            return $twig;
        };
        $container['session'] = function () {
            return new Session();
        };
        $container['controllerDecorator'] = function (Container $container) {
            return new ControllerDecorator(
                $container['twig'],
                $container['router'],
                $container['session']
            );
        };
        $container['callableResolver'] = function (Container $container) {
            return new DecoratingCallableResolver(
                $container,
                $container['controllerDecorator']
            );
        };
        $container['dbal'] = function (Container $container) {
            $config = new Configuration();

            return DriverManager::getConnection([
                'driver'   => 'pdo_mysql',
                'host'     => $container['config']['database']['host'],
                'port'     => $container['config']['database']['port'],
                'dbname'   => $container['config']['database']['name'],
                'user'     => $container['config']['database']['user'],
                'password' => $container['config']['database']['password'],
                'charset'  => $container['config']['database']['charset'],
            ], $config);
        };

        // Controllers
        $container[PasteController::class] = function (Container $container) {
            $pasteRepository = new DbalPasteRepository($container['dbal'], new DbalPasteMapper());

            return new PasteController($pasteRepository, new AES256Crypter());
        };
        $container[ErrorController::class] = function (Container $container) {
            /** @var ControllerDecorator $controllerDecorator */
            $controllerDecorator = $container['controllerDecorator'];

            $errorController = new ErrorController(
                new HttpsXkcdRepository()
            );
            $controllerDecorator->decorate($errorController);

            return $errorController;
        };
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
