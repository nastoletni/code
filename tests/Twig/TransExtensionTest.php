<?php

namespace Nastoletni\Code\Twig;


use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\TranslatorInterface;

class TransExtensionTest extends TestCase
{
    public function testGetFilters()
    {
        $extension = new TransExtension($this->createMock(TranslatorInterface::class));
        /** @var \Twig_SimpleFilter $filter */
        $filter = $extension->getFilters()[0];

        $this->assertInstanceOf(\Twig_SimpleFilter::class, $filter);
        $this->assertEquals('trans', $filter->getName());
    }
}
