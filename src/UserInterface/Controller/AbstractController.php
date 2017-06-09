<?php
declare(strict_types=1);

namespace Nastoletni\Code\UserInterface\Controller;

use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

abstract class AbstractController
{
    /**
     * @var Twig
     */
    protected $twig;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * Pseudo constructor to use by decorator.
     *
     * @param Twig $twig
     * @param RouterInterface $router
     * @param SessionInterface $session
     */
    public function pseudoConstructor(Twig $twig, RouterInterface $router, SessionInterface $session): void
    {
        $this->twig = $twig;
        $this->router = $router;
        $this->session = $session;
    }
}
