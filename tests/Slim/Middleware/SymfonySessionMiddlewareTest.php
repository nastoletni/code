<?php

namespace Nastoletni\Code\Slim\Middleware;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class SymfonySessionMiddlewareTest extends TestCase
{
    public function testStartingSession()
    {
        $sessionMock = $this->createMock(Session::class);
        $sessionMock
            ->expects($this->once())
            ->method('start');

        $middleware = new SymfonySessionMiddleware($sessionMock);

        $middleware(
            $this->createMock(ServerRequestInterface::class),
            $this->createMock(ResponseInterface::class),
            function (ServerRequestInterface $request, ResponseInterface $response) {
                return $response;
            }
        );
    }
}
