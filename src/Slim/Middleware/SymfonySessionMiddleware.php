<?php
declare(strict_types=1);

namespace Nastoletni\Code\Slim\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SymfonySessionMiddleware
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * SymfonySessionMiddleware constructor.
     *
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        $this->session->start();

        return $next($request, $response);
    }
}
