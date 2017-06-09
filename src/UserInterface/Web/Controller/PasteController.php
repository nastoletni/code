<?php
declare(strict_types=1);

namespace Nastoletni\Code\UserInterface\Web\Controller;

use Nastoletni\Code\Application\Form\CreatePasteFormValidator;
use Nastoletni\Code\Application\Crypter\PasteCrypter;
use Nastoletni\Code\Application\Service\CreatePasteService;
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
     * @var PasteCrypter
     */
    private $pasteCrypter;

    /**
     * PasteController constructor.
     *
     * @param PasteRepository $pasteRepository
     * @param PasteCrypter $pasteCrypter
     */
    public function __construct(PasteRepository $pasteRepository, PasteCrypter $pasteCrypter)
    {
        $this->pasteRepository = $pasteRepository;
        $this->pasteCrypter = $pasteCrypter;
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
        return $this->twig->render($response, 'home.twig', [
            'errors' => $this->session->getFlashBag()->get('errors')[0]
        ]);
    }

    /**
     * create: POST /
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $validator = CreatePasteFormValidator::create();
        $errors = $validator->validate($data);

        if (count($errors) > 0) {
            $this->session->getFlashBag()->add('errors', $errors);

            return $response
                ->withStatus(302)
                ->withHeader('Location', $this->router->relativePathFor('home'));
        }

        $createPasteService = new CreatePasteService($this->pasteRepository, $this->pasteCrypter);
        $payload = $createPasteService->handle($data);

        $paste = $payload->getPaste();

        return $response
            ->withStatus(302)
            ->withHeader('Location', $this->router->relativePathFor('paste', [
                'id' => $paste->getId()->getBase62Id(),
                'key' => $payload->getEncryptionKey()
            ]));
    }

    /**
     * paste: GET /{id}/{key}
     *
     * @param Request $request
     * @param Response $response
     * @param string $id
     * @param string $key
     * @return Response
     */
    public function paste(Request $request, Response $response, string $id, string $key): Response
    {
        try {
            $paste = $this->pasteRepository->getById(Id::createFromBase62($id));
        } catch (NotExistsException $e) {
            $response->getBody()->write('404');
            return $response->withStatus(404);
        }

        $this->pasteCrypter->decrypt($paste, $key);

        return $this->twig->render($response, 'paste.twig', [
            'paste' => $paste
        ]);
    }
}
