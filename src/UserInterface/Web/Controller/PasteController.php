<?php
declare(strict_types=1);

namespace Nastoletni\Code\UserInterface\Web\Controller;

use Nastoletni\Code\UserInterface\Controller\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PasteController extends AbstractController
{
    public function home(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $response->getBody()->write('Paste controller, home action');
    }
}