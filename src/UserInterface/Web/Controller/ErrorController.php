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
     * @param int $error
     * @return Response
     */
    private function render(Response $response, int $error): Response
    {
        // FIXME: Maybe split this to separate repository?
        // 1851th is the last xkcd's comic available at the time of writing this.
        $number = random_int(1, 1851);
        $xkcdResponse = file_get_contents(sprintf('http://xkcd.com/%d/info.0.json', $number));
        $xkcdImage = json_decode($xkcdResponse, true);

        return $this->twig->render($response, 'error.twig', [
            'error' => $error,
            'xkcdImage' => $xkcdImage
        ])
            ->withStatus($error);
    }
}
