<?php

namespace Nastoletni\Code\UserInterface\Controller;

use Nastoletni\Code\UserInterface\Controller\AbstractController;
use PHPUnit\Framework\TestCase;
use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;

class AbstractControllerTest extends TestCase
{
    public function testPseudoConstructor()
    {
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

        $twig = $this->createMock(Twig::class);
        $router = $this->createMock(RouterInterface::class);

        $controller->pseudoConstructor($twig, $router);

        $this->assertEquals($twig, $controller->getTwig());
        $this->assertEquals($router, $controller->getRouter());
    }
}
