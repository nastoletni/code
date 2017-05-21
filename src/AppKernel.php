<?php
declare(strict_types=1);

namespace Nastoletni\Code;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Nastoletni\Code\Slim\DecoratingCallableResolver;
use Nastoletni\Code\UserInterface\Controller\ControllerDecorator;
use Slim\App;
use Slim\Container;
use Slim\Handlers\Error;
use Slim\Handlers\PhpError;
use Slim\Views\Twig;
use Symfony\Component\Yaml\Yaml;

class AppKernel
{
    private $environment;
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
        $container['errorHandler'] = function (Container $container) {
            return new Slim\Handler\LoggingErrorHandler(
                $container->get('logger'),
                new Error()
            );
        };
        $container['phpErrorHandler'] = function (Container $container) {
            return new Slim\Handler\LoggingErrorHandler(
                $container->get('logger'),
                new PhpError()
            );
        };
        $container['twig'] = function (Container $container) {
            return new Twig(__DIR__.'/../resources/views/', [
                'debug' => $container['config']['debug']
            ]);
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
