<?php

declare(strict_types=1);

namespace Nastoletni\Code\UserInterface\Web\Controller;

use Nastoletni\Code\Domain\XkcdRepository;
use Nastoletni\Code\UserInterface\Controller\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Throwable;

class ErrorController extends AbstractController
{
    /**
     * @var XkcdRepository
     */
    private $xkcdRepository;

    /**
     * ErrorController constructor.
     *
     * @param XkcdRepository $xkcdRepository
     */
    public function __construct(XkcdRepository $xkcdRepository)
    {
        $this->xkcdRepository = $xkcdRepository;
    }

    /**
     * Handling 404 Not found.
     *
     * @param Request  $request
     * @param Response $response
     *
     * @return Response
     */
    public function notFound(Request $request, Response $response): Response
    {
        return $this->render($response, 404);
    }

    /**
     * Handling 500 Internal server error.
     *
     * @param Request   $request
     * @param Response  $response
     * @param Throwable $exception
     *
     * @return Response
     */
    public function error(Request $request, Response $response, Throwable $exception): Response
    {
        return $this->render($response, 500);
    }

    /**
     * Takes care of all common things to these error pages, such as image from xkcd.
     *
     * @param Response $response
     * @param int      $error
     *
     * @return Response
     */
    private function render(Response $response, int $error): Response
    {
        return $this->twig->render($response, 'error.twig', [
            'error'     => $error,
            'xkcdImage' => $this->xkcdRepository->getRandom(),
        ])
            ->withStatus($error);
    }
}
