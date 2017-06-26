<?php

declare(strict_types=1);

namespace Nastoletni\Code\UserInterface\Controller;

use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;

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
     * @var Session
     */
    protected $session;

    /**
     * Pseudo constructor to use by decorator.
     *
     * @param Twig            $twig
     * @param RouterInterface $router
     * @param Session         $session
     */
    public function pseudoConstructor(Twig $twig, RouterInterface $router, Session $session): void
    {
        $this->twig = $twig;
        $this->router = $router;
        $this->session = $session;
    }

    /**
     * Adds given value to the flashed variables bag.
     *
     * @param string $name
     * @param        $value
     */
    protected function flash(string $name, $value): void
    {
        $this->session->getFlashBag()->add($name, $value);
    }

    /**
     * Returns flashed value with given name.
     *
     * @param string $name
     *
     * @return mixed|null
     */
    protected function getFlash(string $name)
    {
        if (false == $this->session->getFlashBag()->has($name)) {
            return null;
        }

        $flash = $this->session->getFlashBag()->get($name);

        return $flash[0] ?? null;
    }
}
