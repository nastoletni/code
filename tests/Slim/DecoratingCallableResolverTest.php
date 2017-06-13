<?php

namespace Nastoletni\Code\Slim;

use Nastoletni\Code\UserInterface\Controller\AbstractController;
use Nastoletni\Code\UserInterface\Controller\ControllerDecorator;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DecoratingCallableResolverTest extends TestCase
{
    public function testResolveWithChildOfAbstractControllerWithMethodInContainer()
    {
        $container = $this->getContainerWithClassMethod();
        /** @var AbstractController $controller */
        $controller = $container->get('controller');

        $controllerDecorator = $this->createMock(ControllerDecorator::class);
        $controllerDecorator
            ->expects($this->once())
            ->method('decorate');

        $decoratingCallableResolver = new DecoratingCallableResolver(
            $container,
            $controllerDecorator
        );

        $resolved = $decoratingCallableResolver->resolve('controller:home');
        $this->assertEquals($controller, $resolved[0]);
        $this->assertEquals('home', $resolved[1]);
    }

    public function testResolveWithInvokableChildOfAbstractControllerInContainer()
    {
        $container = $this->getContainerWithInvokableClass();
        /** @var AbstractController $controller */
        $controller = $container->get('controller');

        $controllerDecorator = $this->createMock(ControllerDecorator::class);
        $controllerDecorator
            ->expects($this->once())
            ->method('decorate');

        $decoratingCallableResolver = new DecoratingCallableResolver(
            $container,
            $controllerDecorator
        );

        $resolved = $decoratingCallableResolver->resolve('controller');
        $this->assertEquals($controller, $resolved[0]);
        $this->assertEquals('__invoke', $resolved[1]);
    }

    public function testResolveWithChildOfAbstractControllerWithMethod()
    {
        $controller = new class() extends AbstractController {
            public function home(
                ServerRequestInterface $request,
                ResponseInterface $response
            ) {
                return $response;
            }
        };

        $controllerDecorator = $this->createMock(ControllerDecorator::class);
        $controllerDecorator
            ->expects($this->once())
            ->method('decorate');

        $decoratingCallableResolver = new DecoratingCallableResolver(
            $this->createMock(ContainerInterface::class),
            $controllerDecorator
        );

        $resolved = $decoratingCallableResolver->resolve([$controller, 'home']);
        $this->assertEquals($controller, $resolved[0]);
        $this->assertEquals('home', $resolved[1]);
    }

    public function testResolveWithInvokableChildOfAbstractController()
    {
        $controller = new class() extends AbstractController {
            public function __invoke(
                ServerRequestInterface $request,
                ResponseInterface $response
            ) {
                return $response;
            }
        };

        $controllerDecorator = $this->createMock(ControllerDecorator::class);
        $controllerDecorator
            ->expects($this->once())
            ->method('decorate');

        $decoratingCallableResolver = new DecoratingCallableResolver(
            $this->createMock(ContainerInterface::class),
            $controllerDecorator
        );

        $resolved = $decoratingCallableResolver->resolve($controller);
        $this->assertEquals($controller, $resolved);
    }

    public function testResolveWithNotChildOfAbstractController()
    {
        $controller = new class() {
            public function home(
                ServerRequestInterface $request,
                ResponseInterface $response
            ) {
                return $response;
            }
        };

        $controllerDecorator = $this->createMock(ControllerDecorator::class);
        $controllerDecorator
            ->expects($this->never())
            ->method('decorate');

        $decoratingCallableResolver = new DecoratingCallableResolver(
            $this->createMock(ContainerInterface::class),
            $controllerDecorator
        );

        $resolved = $decoratingCallableResolver->resolve([$controller, 'home']);
        $this->assertEquals($controller, $resolved[0]);
        $this->assertEquals('home', $resolved[1]);
    }

    private function getContainerWithClassMethod()
    {
        return new class() implements ContainerInterface {
            public function get($id)
            {
                return new class() extends AbstractController {
                    public function home(
                        ServerRequestInterface $request,
                        ResponseInterface $response
                    ) {
                        return $response;
                    }
                };
            }

            public function has($id)
            {
                return 'controller' == $id;
            }
        };
    }

    public function getContainerWithInvokableClass()
    {
        return new class() implements ContainerInterface {
            public function get($id)
            {
                return new class() extends AbstractController {
                    public function __invoke(
                        ServerRequestInterface $request,
                        ResponseInterface $response
                    ) {
                        return $response;
                    }
                };
            }

            public function has($id)
            {
                return 'controller' == $id;
            }
        };
    }
}
