<?php
declare(strict_types=1);

namespace Nastoletni\Code\UserInterface\Controller;

use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;

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
     * Pseudo constructor to use by decorator.
     *
     * @param Twig $twig
     * @param RouterInterface $router
     */
    public function pseudoConstructor(Twig $twig, RouterInterface $router): void
    {
        $this->twig = $twig;
        $this->router = $router;
    }
}
