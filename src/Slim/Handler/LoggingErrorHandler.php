<?php
declare(strict_types=1);

namespace Nastoletni\Code\Slim\Handler;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Exception;

class LoggingErrorHandler
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var callable|null
     */
    private $nextHandler;

    /**
     * LoggingErrorHandler constructor.
     *
     * @param LoggerInterface $logger
     * @param callable|null $nextHandler
     */
    public function __construct(LoggerInterface $logger, ?callable $nextHandler = null)
    {
        $this->logger = $logger;
        $this->nextHandler = $nextHandler;
    }

    /**
     * Logs exceptions to logger.
     *
     * @param Request $request
     * @param Response $response
     * @param Exception $exception
     * @return Response
     */
    public function __invoke(Request $request, Response $response, Exception $exception): Response
    {
        $this->logger->critical($exception);

        if (!is_null($this->nextHandler)) {
            return ($this->nextHandler)($request, $response, $exception);
        }

        return $response;
    }
}
