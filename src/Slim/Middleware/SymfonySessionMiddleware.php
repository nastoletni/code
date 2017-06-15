<?php

declare(strict_types=1);

namespace Nastoletni\Code\Slim\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class SymfonySessionMiddleware
{
    /**
     * @var Session
     */
    private $session;

    /**
     * SymfonySessionMiddleware constructor.
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Starts session.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable               $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        $this->session->start();

        return $next($request, $response);
    }
}
