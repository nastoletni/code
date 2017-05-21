<?php

namespace Nastoletni\Code\Slim\Handler;

use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class LoggingErrorHandlerTest extends TestCase
{
    public function testInvoke()
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects($this->once())
            ->method('critical');

        $loggingErrorHandler = new LoggingErrorHandler($logger);

        $invokeParams = $this->createInvokeParamsMocks();
        $response = $loggingErrorHandler(...$invokeParams);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testInvokeWithNextHandler()
    {
        $logger = $this->createMock(LoggerInterface::class);

        $invokeParams = $this->createInvokeParamsMocks();

        $called = false;
        $nextHandler = function (
            ServerRequestInterface $request,
            ResponseInterface $response,
            Exception $exception
        ) use (&$called) {
            $called = true;

            return $response;
        };

        $loggingErrorHandler = new LoggingErrorHandler($logger, $nextHandler);
        $loggingErrorHandler(...$invokeParams);

        $this->assertTrue($called);
    }

    private function createInvokeParamsMocks()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $exception = new Exception();

        return [$request, $response, $exception];
    }
}
