<?php
declare(strict_types=1);

namespace Nastoletni\Code\UserInterface\Web\Controller;

use Nastoletni\Code\UserInterface\Controller\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PasteController extends AbstractController
{
    public function home(Request $request, Response $response): Response
    {
        return $response->getBody()->write('Paste controller, home action');
    }
}