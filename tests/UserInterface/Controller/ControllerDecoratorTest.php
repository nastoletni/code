<?php

namespace Nastoletni\Code\UserInterface\Controller;

use PHPUnit\Framework\TestCase;
use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;

class ControllerDecoratorTest extends TestCase
{
    public function testDecorate()
    {
        $twig = $this->createMock(Twig::class);
        $router = $this->createMock(RouterInterface::class);
        $session = $this->createMock(Session::class);
        $decorator = new ControllerDecorator($twig, $router, $session);

        $controller = new class extends AbstractController {
            public function getTwig()
            {
                return $this->twig;
            }

            public function getRouter()
            {
                return $this->router;
            }

            public function getSession()
            {
                return $this->session;
            }
        };

        $decorator->decorate($controller);

        $this->assertEquals($twig, $controller->getTwig());
        $this->assertEquals($router, $controller->getRouter());
        $this->assertEquals($session, $controller->getSession());
    }
}
