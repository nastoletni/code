<?php

declare(strict_types=1);

namespace Nastoletni\Code\Twig;

use Symfony\Component\Translation\TranslatorInterface;

class TransExtension extends \Twig_Extension
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * TransExtension constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('trans', [$this, 'trans'])
        ];
    }

    /**
     * Translates given message using Translation component.
     *
     * @param $message
     *
     * @return string
     */
    public function trans($message)
    {
        return $this->translator->trans($message);
    }
}