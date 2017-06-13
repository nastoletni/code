<?php
declare(strict_types=1);

namespace Nastoletni\Code\UserInterface\Web\Controller;

use Nastoletni\Code\UserInterface\Controller\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Throwable;

class ErrorController extends AbstractController
{
    /**
     * Handling 404 Not found
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function notFound(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'error.twig', ['error' => 404])
            ->withStatus(404);
    }

    /**
     * Handling 500 Internal server error
     *
     * @param Request $request
     * @param Response $response
     * @param Throwable $exception
     * @return Response
     */
    public function error(Request $request, Response $response, Throwable $exception): Response
    {
        return $this->twig->render($response, 'error.twig', ['error' => 500])
            ->withStatus(500);
    }
}
