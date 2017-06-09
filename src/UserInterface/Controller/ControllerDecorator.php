<?php
declare(strict_types=1);

namespace Nastoletni\Code\UserInterface\Controller;

use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ControllerDecorator
{
    /**
     * @var Twig
     */
    private $twig;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * ControllerDecorator constructor.
     *
     * @param Twig $twig
     * @param RouterInterface $router
     * @param SessionInterface $session
     */
    public function __construct(Twig $twig, RouterInterface $router, SessionInterface $session)
    {
        $this->twig = $twig;
        $this->router = $router;
        $this->session = $session;
    }

    /**
     * Decorates controller with common to all controllers dependencies.
     *
     * @param AbstractController $controller
     */
    public function decorate(AbstractController $controller): void
    {
        $controller->pseudoConstructor($this->twig, $this->router, $this->session);
    }
}
