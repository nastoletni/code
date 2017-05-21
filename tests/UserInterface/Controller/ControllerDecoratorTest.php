<?php

namespace Nastoletni\Code\UserInterface\Controller;

use PHPUnit\Framework\TestCase;
use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;

class ControllerDecoratorTest extends TestCase
{
    public function testDecorate()
    {
        $twig = $this->createMock(Twig::class);
        $router = $this->createMock(RouterInterface::class);
        $decorator = new ControllerDecorator($twig, $router);

        $controller = new class extends AbstractController {
            public function getTwig()
            {
                return $this->twig;
            }

            public function getRouter()
            {
                return $this->router;
            }
        };

        $decorator->decorate($controller);

        $this->assertEquals($twig, $controller->getTwig());
        $this->assertEquals($router, $controller->getRouter());
    }
}
