<?php

namespace Nastoletni\Code\UserInterface\Controller;

use Nastoletni\Code\UserInterface\Controller\AbstractController;
use PHPUnit\Framework\TestCase;
use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;

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

            public function getSession()
            {
                return $this->session;
            }
        };

        $twig = $this->createMock(Twig::class);
        $router = $this->createMock(RouterInterface::class);
        $session = $this->createMock(Session::class);

        $controller->pseudoConstructor($twig, $router, $session);

        $this->assertEquals($twig, $controller->getTwig());
        $this->assertEquals($router, $controller->getRouter());
        $this->assertEquals($session, $controller->getSession());
    }
}
