<?php
declare(strict_types=1);

namespace Nastoletni\Code\UserInterface\Web\Controller;

use Nastoletni\Code\Domain\Paste\Id;
use Nastoletni\Code\Domain\Paste\NotExistsException;
use Nastoletni\Code\Domain\PasteRepository;
use Nastoletni\Code\UserInterface\Controller\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PasteController extends AbstractController
{
    /**
     * @var PasteRepository
     */
    private $pasteRepository;

    /**
     * PasteController constructor.
     *
     * @param PasteRepository $pasteRepository
     */
    public function __construct(PasteRepository $pasteRepository)
    {
        $this->pasteRepository = $pasteRepository;
    }

    /**
     * home: GET /
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function home(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'home.twig');
    }

    /**
     * paste: GET /{id}
     *
     * @param Request $request
     * @param Response $response
     * @param string $id
     * @return Response
     */
    public function paste(Request $request, Response $response, string $id): Response
    {
        try {
            $paste = $this->pasteRepository->getById(Id::createFromBase62($id));
        } catch (NotExistsException $e) {
            $response->getBody()->write('404');
            return $response->withStatus(404);
        }

        return $this->twig->render($response, 'paste.twig', [
            'paste' => $paste
        ]);
    }
}
