<?php
declare(strict_types=1);

namespace Nastoletni\Code\UserInterface\Controller;

use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;

class ControllerDecorator
{
    private $twig;
    private $router;

    /**
     * ControllerDecorator constructor.
     *
     * @param Twig $twig
     * @param RouterInterface $router
     */
    public function __construct(Twig $twig, RouterInterface $router)
    {
        $this->twig = $twig;
        $this->router = $router;
    }

    /**
     * Decorates controller with common to all controllers dependencies.
     *
     * @param AbstractController $controller
     */
    public function decorate(AbstractController $controller): void
    {
        $controller->pseudoConstructor($this->twig, $this->router);
    }
}